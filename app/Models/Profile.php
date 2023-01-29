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

    protected $fillable = ['user_id', 'country_id', 'nic_verified_at', 'driving_lc_verified_at', 'passport_verified_at',
        'street', 'state', 'address', 'zip_code', 'home_phone', 'recover_email', 'gender', 'dob'];

    protected $appends = [
        'is_nic_verified',
        'is_driving_lc_verified',
        'is_passport_verified',
        'is_kyc_verified'
    ];

    public function getIsNicVerifiedAttribute(): bool
    {
        return $this->is_nic_verified = $this->nic_verified_at !== null;
    }

    public function getIsDrivingLcVerifiedAttribute(): bool
    {
        return $this->is_driving_lc_verified = $this->driving_lc_verified_at !== null;
    }

    public function getIsPassportVerifiedAttribute(): bool
    {
        return $this->is_passport_verified = $this->passport_verified_at !== null;
    }

    public function getIsKycVerifiedAttribute(): bool
    {
        return $this->is_kyc_verified = ($this->is_nic_verified || $this->is_passport_verified || $this->is_driving_lc_verified);
    }

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
