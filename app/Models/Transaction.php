<?php

namespace App\Models;

use App\Models\PaymentGateway;
use App\Models\TransactionItem;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    const STATUS_UNPAID = 0;
    const STATUS_PENDING = 1;
    const STATUS_PAID = 2;
    const STATUS_CANCELLED = 3;

    const TYPE_PURCHASE = 'purchase';
    const TYPE_SUPPORT_PURCHASE = 'support_purchase';
    const TYPE_SUPPORT_EXTEND = 'support_extend';
    const TYPE_DEPOSIT = 'deposit';
    const TYPE_SUBSCRIPTION = 'subscription';

    protected static function boot()
    {
        parent::boot();

        static::deleted(function ($transaction) {
            if ($transaction->payment_proof) {
                removeFileFromStorage($transaction->payment_proof, 'local');
            }
        });
    }

    public function scopeUnpaid($query)
    {
        return $query->where('status', self::STATUS_UNPAID);
    }

    public function isUnpaid()
    {
        return $this->status == self::STATUS_UNPAID;
    }

    public function scopePending($query)
    {
        return $query->where('status', self::STATUS_PENDING);
    }

    public function isPending()
    {
        return $this->status == self::STATUS_PENDING;
    }

    public function scopePaid($query)
    {
        return $query->where('status', self::STATUS_PAID);
    }

    public function isPaid()
    {
        return $this->status == self::STATUS_PAID;
    }

    public function scopeCancelled($query)
    {
        return $query->where('status', self::STATUS_CANCELLED);
    }

    public function isCancelled()
    {
        return $this->status == self::STATUS_CANCELLED;
    }

    public function hasFees()
    {
        return $this->fees > 0;
    }

    public function hasTax()
    {
        return $this->tax != null;
    }

    public function isTypePurchase()
    {
        return $this->type == self::TYPE_PURCHASE;
    }

    public function isTypeSupportPurchase()
    {
        return $this->type == self::TYPE_SUPPORT_PURCHASE;
    }

    public function isTypeSupportExtend()
    {
        return $this->type == self::TYPE_SUPPORT_EXTEND;
    }

    public function isTypeDeposit()
    {
        return $this->type == self::TYPE_DEPOSIT;
    }

    public function isTypeSubscription()
    {
        return $this->type == self::TYPE_SUBSCRIPTION;
    }

    protected $fillable = [
        'user_id',
        'amount',
        'tax',
        'fees',
        'total',
        'payment_id',
        'payer_id',
        'payer_email',
        'payment_proof',
        'type',
        'support',
        'purchase_id',
        'plan_id',
        'status',
        'cancellation_reason',
    ];

    protected $with = [
        'trxItems',
    ];

    protected $casts = [
        'tax' => 'object',
        'support' => 'object',
    ];

    public static function getStatusOptions()
    {
        return [
            self::STATUS_PENDING => translate('Pending'),
            self::STATUS_PAID => translate('Paid'),
            self::STATUS_CANCELLED => translate('Cancelled'),
        ];
    }

    public function getStatusName()
    {
        return self::getStatusOptions()[$this->status];
    }

    public static function getTypeOptions()
    {
        return [
            self::TYPE_PURCHASE => translate('Purchase'),
            self::TYPE_SUPPORT_PURCHASE => translate('Support Purchase'),
            self::TYPE_SUPPORT_EXTEND => translate('Support Extend'),
            self::TYPE_DEPOSIT => translate('Deposit'),
            self::TYPE_SUBSCRIPTION => translate('Subscription'),
        ];
    }

    public function getTypeName()
    {
        return self::getTypeOptions()[$this->type];
    }

    public function calculate()
    {
        $total = $this->amount;

        $tax = null;

        $user = $this->user;

        if (!$this->isTypeDeposit()) {
            $tax = Tax::whereJsonContains('countries', @$user->address->country)->first();
            if ($tax) {
                $taxRate = $tax->rate;
                $taxAmount = round((($total * $taxRate) / 100), 2);

                $tax = [
                    'name' => $tax->name,
                    'rate' => $taxRate,
                    'amount' => $taxAmount,
                ];

                $total += $taxAmount;
            }
        }

        $paymentGateway = $this->paymentGateway;

        $fees = 0;
        if ($paymentGateway->fees > 0) {
            $fees = ($total * $paymentGateway->fees) / 100;
        }

        $total += round($fees, 2);

        $this->tax = $tax;
        $this->fees = $fees;
        $this->total = $total;
        $this->update();
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function paymentGateway()
    {
        return $this->belongsTo(PaymentGateway::class);
    }

    public function trxItems()
    {
        return $this->hasMany(TransactionItem::class);
    }

    public function purchase()
    {
        return $this->belongsTo(Purchase::class);
    }

    public function plan()
    {
        return $this->belongsTo(Plan::class);
    }
}
