<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KycVerification extends Model
{
    use HasFactory;

    const STATUS_PENDING = 1;
    const STATUS_APPROVED = 2;
    const STATUS_REJECTED = 3;

    const DOCUMENT_TYPE_NATIONAL_ID = 'national_id';
    const DOCUMENT_TYPE_PASSPORT = 'passport';

    protected static function boot()
    {
        parent::boot();

        static::deleted(function ($kycVerification) {
            foreach ($kycVerification->documents as $key => $document) {
                if ($document) {
                    removeFileFromStorage($document, 'local');
                }
            }
        });
    }

    public function scopePending($query)
    {
        $query->where('status', self::STATUS_PENDING);
    }

    public function isPending()
    {
        return $this->status == self::STATUS_PENDING;
    }

    public function scopeApproved($query)
    {
        $query->where('status', self::STATUS_APPROVED);
    }

    public function isApproved()
    {
        return $this->status == self::STATUS_APPROVED;
    }

    public function scopeRejected($query)
    {
        $query->where('status', self::STATUS_REJECTED);
    }

    public function isRejected()
    {
        return $this->status == self::STATUS_REJECTED;
    }

    public function isNationalIdDocument()
    {
        return $this->document_type == self::DOCUMENT_TYPE_NATIONAL_ID;
    }

    public function isPassportDocument()
    {
        return $this->document_type == self::DOCUMENT_TYPE_PASSPORT;
    }

    protected $fillable = [
        'user_id',
        'document_type',
        'document_number',
        'documents',
        'status',
        'rejection_reason',
    ];

    protected $casts = [
        'documents' => 'object',
    ];

    public static function getDocumentTypeOptions()
    {
        return [
            self::DOCUMENT_TYPE_NATIONAL_ID => 'National ID',
            self::DOCUMENT_TYPE_PASSPORT => 'Passport',
        ];
    }

    public function getDocumentType()
    {
        return self::getDocumentTypeOptions()[$this->document_type];
    }

    public static function getStatusOptions()
    {
        return [
            self::STATUS_PENDING => translate('Pending'),
            self::STATUS_APPROVED => translate('Approved'),
            self::STATUS_REJECTED => translate('Rejected'),
        ];
    }

    public function getStatusName()
    {
        return self::getStatusOptions()[$this->status];
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}