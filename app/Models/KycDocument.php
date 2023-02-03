<?php

namespace App\Models;

use Haruncpi\LaravelUserActivity\Traits\Loggable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class KycDocument extends Model
{
    use SoftDeletes;
    use Loggable;

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

    protected function getStatusColorAttribute(): string
    {
        return self::STATUS_COLORS[$this->status];
    }

    protected function getDocumentTypeAttribute(): string
    {
        return self::DOCUMENT_TYPES[$this->type];
    }

    protected function getDocumentTypeNameAttribute(): string
    {
        return self::DOCUMENT_TYPE_NAMES[$this->kyc->type][$this->type];
    }
}
