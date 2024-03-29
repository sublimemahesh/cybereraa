<?php

namespace App\Models;

use Haruncpi\LaravelUserActivity\Traits\Loggable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Kyc extends Model
{
    use SoftDeletes;
    use Loggable;

    protected $withCount = ['documents'];

    protected $fillable = ['profile_id', 'type', 'status'];

    public const KYC_TYPES = [
        'nic' => 'National Identity Card',
        'driving_lc' => 'Driving License',
        'passport' => 'Passport'
    ];
    public const KYC_PROFILE_NAMES = [
        'nic' => 'nic',
        'driving_lc' => 'driving_lc_number',
        'passport' => 'passport_number'
    ];

    private const STATUS_COLORS = [
        'pending' => 'warning',
        'accepted' => 'success',
        'rejected' => 'danger'
    ];
    public const REQUIRED_DOCUMENTS = [
        'nic' => 3,
        'driving_lc' => 2,
        'passport' => 2
    ];

    public function profile()
    {
        return $this->belongsTo(Profile::class, 'profile_id')->withDefault(new Profile);
    }

    public function documents(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(KycDocument::class, 'kyc_id');
    }

    protected function getKycTypeAttribute(): string
    {
        return self::KYC_TYPES[$this->type];
    }

    protected function getRequiredDocumentsAttribute(): int
    {
        return self::REQUIRED_DOCUMENTS[$this->type];
    }

    protected function getStatusColorAttribute(): string
    {
        return self::STATUS_COLORS[$this->status];
    }

    protected function getProfileNameAttribute(): string
    {
        return self::KYC_PROFILE_NAMES[$this->type];
    }

}
