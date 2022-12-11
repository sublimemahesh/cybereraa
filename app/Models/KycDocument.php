<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KycDocument extends Model
{
    use HasFactory;

    protected $fillable = [
        'kyc_id',
        'document_name',
        'type',
        'status',
    ];

    public const DOCUMENT_TYPES = [
        'front' => 'FRONT',
        'back' => 'BACK',
        'other' => 'OTHER'
    ];
    private const STATUS_COLORS = [
        'required' => 'dark',
        'pending' => 'warning',
        'accepted' => 'success',
        'rejected' => 'danger'
    ];
    public const DOCUMENT_TYPE_NAMES = [
        'nic' => [
            'front' => 'NIC front image',
            'back' => 'NIC back image',
            'other' => 'SELFIE WITH NIC'
        ],
        'driving_lc' => [
            'front' => 'Driving License front image',
            'other' => 'SELFIE WITH DRIVING LICENSE'
        ],
        'passport' => [
            'front' => 'Passport first page',
            'other' => 'SELFIE WITH PASSPORT'
        ]
    ];

    protected $with = ['kyc'];

    public function kyc()
    {
        return $this->belongsTo(Kyc::class, 'kyc_id');
    }

    public function getStatusColorAttribute(): string
    {
        return Self::STATUS_COLORS[$this->status];
    }

    public function getDocumentTypeAttribute(): string
    {
        return Self::DOCUMENT_TYPES[$this->type];
    }

    public function getDocumentTypeNameAttribute(): string
    {
        return Self::DOCUMENT_TYPE_NAMES[$this->kyc->type][$this->type];
    }
}
