<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Profile extends Model
{
    use HasFactory;
    use softDeletes;

    protected $withCount = ['kycs'];

    public function user(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id')->withDefault(new User);
    }

    public function country(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Country::class, 'country_id', 'id')->withDefault(new Country);
    }

    public function kycs(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Kyc::class, 'profile_id');
    }
}
