<?php

namespace App\Models;

use Dyrynda\Database\Support\CascadeSoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use JsonException;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Jetstream\HasTeams;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use Staudenmeir\LaravelAdjacencyList\Eloquent\HasRecursiveRelationships;
use Throwable;
use URL;

class User extends Authenticatable
{
    use HasRoles;
    use HasApiTokens;
    use HasFactory;
    use HasProfilePhoto;
    use HasTeams;
    use Notifiable;
    use TwoFactorAuthenticatable;
    use softDeletes, CascadeSoftDeletes;
    use HasRecursiveRelationships;

    protected $with = ['profile'];

    protected array $cascadeDeletes = ['ranks'];

    protected $dates = ['deleted_at'];

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'name', 'email', 'password', 'phone', 'super_parent_id', 'parent_id', 'username', 'position'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [
        /*'depth',
        'highest_rank',*/
        'profile_photo_url',
        'referral_link'
    ];


    public function getReferralLinkAttribute(): string
    {
        return $this->referral_link = URL::signedRoute('register', ['ref' => $this->username]);
    }

    public function getIsActiveAttribute(): bool
    {
        return $this->purchasedPackages()->activePackages()->count() >= 1;
    }

    public function sponsor(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(self::class, 'super_parent_id', 'id')->withDefault(new User);
    }

    public function directSales(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(self::class, 'super_parent_id', 'id');
    }

    public function wallet(): HasOne
    {
        return $this->hasOne(Wallet::class, 'user_id')->withDefault(new Wallet);
    }

    public function profile(): \Illuminate\Database\Eloquent\Relations\HasOne
    {
        return $this->hasOne(Profile::class, 'user_id', 'id')->withDefault(new Profile);
    }

    public function purchasedPackages(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(PurchasedPackage::class, 'user_id', 'id');
    }

    public function activePackages(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->purchasedPackages()->activePackages();

    }

    public function earnings(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Earning::class, 'user_id');
    }

    public function transactions(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Transaction::class, 'user_id', 'id');
    }

    public function getDepthAttribute()
    {
        $depth = DB::selectOne(
            "WITH RECURSIVE user_tree AS (
                      SELECT id, parent_id, 1 as depth
                      FROM users
                      WHERE parent_id IS NULL -- Find the root node(s) of the tree
                      UNION ALL
                      SELECT u.id, u.parent_id, t.depth + 1 as depth
                      FROM users u
                      JOIN user_tree t ON u.parent_id = t.id
                   )
                   SELECT depth FROM user_tree WHERE id = :id",
            ['id' => $this->id]
        );

        return optional($depth)->depth;
    }

    public static function findAvailableSubLevel($nodeId)
    {
        return DB::selectOne("
                WITH RECURSIVE ancestor_nodes AS 
                    (
                        (SELECT * FROM users WHERE id = :node_id)
                        UNION ALL
                        (SELECT n.* FROM users n INNER JOIN ancestor_nodes an ON an.id = n.parent_id)
                    ) 
                    SELECT cte_an.id, cte_an.parent_id, cte_an.`position`, (SELECT COUNT(*) FROM users WHERE parent_id = cte_an.id) AS children_count
                    FROM ancestor_nodes cte_an
                    WHERE (SELECT COUNT(*) FROM users WHERE parent_id = cte_an.id) < 5 ORDER BY  cte_an.`parent_id`, cte_an.`position` ASC LIMIT 1",
            ['node_id' => $nodeId]);
    }

    public function ranks(): HasMany
    {
        return $this->hasMany(Rank::class, 'user_id');
    }

    public function rank($rank): HasOne
    {
        return $this->hasOne(Rank::class, 'user_id')->where('rank', $rank);
    }

    public function currentRank(): HasOne
    {
        return $this->hasOne(Rank::class, 'user_id')
            ->whereNotNull('activated_at')
            ->orderBy('rank', 'desc')
            ->withDefault(new Rank);
    }

    public function getHighestRankAttribute(): int
    {
        $rank = $this->ranks()->whereNotNull('activated_at')->orderBy('rank', 'desc')->first();
        return $rank->rank ?? 0;
    }

    /**
     * @throws JsonException
     */
    public static function getUpgradeRequirements()
    {
        $strategy = Strategy::where('name', 'rank_package_requirement')
            ->firstOr(fn() => new Strategy(['value' => '{"1":100,"2":250,"3":500,"4":1000,"5":2500,"6":5000,"7":10000}']));
        return json_decode($strategy->value, false, 512, JSON_THROW_ON_ERROR);
    }

    /**
     * @throws Throwable
     */
    public static function upgradeAncestorsRank(self $user, $rank, $is_active = false): void
    {
        if ($rank > 7) {
            return;
        }
        if (!empty($user->parent->id) && $user->parent->highest_rank >= $rank) {
            return;
        }

        DB::transaction(static function () use ($rank, $user, $is_active) {

            if ($rank === 1) {
                $eligibility = $user->children()->count();

                $is_active = $eligibility === 5;
                $activated_at = $is_active ? now() : null;
                Rank::updateOrCreate(
                    ['user_id' => $user->id, 'rank' => $rank],
                    compact('eligibility', 'activated_at')
                );

                $rank = 2;
            }

            if ($is_active && !empty($user->parent->id)) {
                $user = $user->parent;

                $user_rank = Rank::firstOrCreate(
                    ['user_id' => $user->id, 'rank' => $rank],
                    ['eligibility' => 0]
                );

                if ($user_rank->eligibility < 5) {
                    $user_rank->increment('eligibility');
                }
                $is_active = $user_rank->eligibility === 5;
                $activated_at = $is_active ? now() : null;
                $user_rank->update(compact('activated_at'));

                if ($is_active) {
                    self::upgradeAncestorsRank($user, $user->highest_rank + 1, true);
                }
            }
        });
    }

}
