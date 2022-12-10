<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Kyc extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = ['profile_id', 'type', 'status'];

    public const KYC_TYPES = [
        'nic' => 'National Identity Card',
        'driving_lc' => 'Driving License',
        'passport' => 'Passport'
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

    public function getKycTypeAttribute(): string
    {
        return Self::KYC_TYPES[$this->type];
    }

    public function getRequiredDocumentsAttribute(): string
    {
        return Self::REQUIRED_DOCUMENTS[$this->type];
    }

    public function getStatusColorAttribute(): string
    {
        return Self::STATUS_COLORS[$this->status];
    }

}
