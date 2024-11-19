<?php

namespace App\Models;

use App\Classes\BrowserDetector;
use App\Classes\OSDetector;
use App\Methods\Gravatar;
use App\Models\KycVerification;
use App\Models\UserLoginLog;
use App\Notifications\ResetPasswordNotification;
use App\Notifications\VerifyEmailNotification;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable;

    const ROLE_USER = 0;
    const ROLE_ADMIN = 1;

    const STATUS_BANNED = 0;
    const STATUS_ACTIVE = 1;

    const KYC_STATUS_UNVERIFIED = 0;
    const KYC_STATUS_VERIFIED = 1;

    const WAS_NOT_SUBSCRIBED = 0;
    const WAS_SUBSCRIBED = 1;

    public function scopeUser($query)
    {
        $query->where('is_admin', self::ROLE_USER);
    }

    public function isUser()
    {
        return $this->is_admin == self::ROLE_USER;
    }

    public function scopeAdmin($query)
    {
        $query->where('is_admin', self::ROLE_ADMIN);
    }

    public function isAdmin()
    {
        return $this->is_admin == self::ROLE_ADMIN;
    }

    public function scopeActive($query)
    {
        $query->where('status', self::STATUS_ACTIVE);
    }

    public function isActive()
    {
        return $this->status == self::STATUS_ACTIVE;
    }

    public function scopeBanned($query)
    {
        $query->where('status', self::STATUS_BANNED);
    }

    public function isBanned()
    {
        return $this->status == self::STATUS_BANNED;
    }

    public function scopeEmailVerified($query)
    {
        $query->whereNotNull('email_verified_at');
    }

    public function scopeEmailUnVerified($query)
    {
        $query->whereNull('email_verified_at');
    }

    public function isEmailVerified()
    {
        return $this->email_verified_at != null;
    }

    public function scopeKycVerified($query)
    {
        $query->where('kyc_status', self::KYC_STATUS_VERIFIED);
    }

    public function isKycVerified()
    {
        return $this->kyc_status == self::KYC_STATUS_VERIFIED;
    }

    public function isKycPending()
    {
        if (!$this->isKycVerified()) {
            $kycVerification = KycVerification::where('user_id', $this->id)->pending()->first();
            if ($kycVerification) {
                return true;
            }
        }
        return false;
    }

    public function isKycRequired()
    {
        if (@settings('kyc')->status && @settings('kyc')->required &&
            !$this->isKycVerified()) {
            return true;
        }
        return false;
    }

    public function scopeKycUnVerified($query)
    {
        $query->where('kyc_status', self::KYC_STATUS_UNVERIFIED);
    }

    public function has2fa()
    {
        return $this->google2fa_status == 1;
    }

    public function scopeWhereDataCompleted($query)
    {
        $query->whereNotNull('firstname')
            ->whereNotNull('lastname')
            ->whereNotNull('username')
            ->whereNotNull('email')
            ->whereNotNull('password');
    }

    public function isDataCompleted()
    {
        if (!$this->firstname || !$this->lastname ||
            !$this->username || !$this->email || !$this->password) {
            return false;
        }
        return true;
    }

    public function hasPurchasedItem($itemID)
    {
        return $this->purchases()->where('item_id', $itemID)->active()->exists();
    }

    public function getItemPurchase($itemID)
    {
        if ($this->hasPurchasedItem($itemID)) {
            $purchase = $this->purchases()->where('item_id', $itemID)->first();
            return $purchase;
        }
    }

    public function hasItemInFavorite($itemID)
    {
        return $this->favorites()->where('item_id', $itemID)->exists();
    }

    public function isSubscribed()
    {
        return !is_null($this->subscription);
    }

    public function subscribedToPlan($planId)
    {
        return $this->subscription && $this->subscription->plan->id == $planId;
    }

    public function wasSubscribed()
    {
        return $this->was_subscribed == self::WAS_SUBSCRIBED;
    }

    protected $fillable = [
        'firstname',
        'lastname',
        'username',
        'email',
        'address',
        'password',
        'balance',
        'avatar',
        'facebook_id',
        'google_id',
        'microsoft_id',
        'vkontakte_id',
        'envato_id',
        'github_id',
        'is_admin',
        'was_subscribed',
        'kyc_status',
        'google2fa_status',
        'google2fa_secret',
        'status',
    ];

    protected $hidden = [
        'password',
        'remember_token',
        'google2fa_secret',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'address' => 'object',
    ];

    public function getName()
    {
        if ($this->firstname && $this->lastname) {
            return $this->firstname . ' ' . $this->lastname;
        } elseif ($this->username) {
            return $this->username;
        } elseif ($this->email) {
            $emailUsername = explode('@', $this->email);
            return $emailUsername[0];
        }
    }

    public function getCountry()
    {
        return @$this->address->country ? countries(@$this->address->country) : null;
    }

    public function getAvatar()
    {
        if ($this->avatar) {
            return asset($this->avatar);
        }
        return Gravatar::get($this->email);
    }

    public function getGoogle2faSecretAttribute($value)
    {
        return decrypt($value);
    }

    public function registerLoginLog()
    {
        if (!$this->isAdmin()) {
            $ipInfo = ipInfo();
            $loginLog = UserLoginLog::where('user_id', $this->id)->where('ip', getIp())->first();
            if (!$loginLog) {
                $loginLog = new UserLoginLog();
                $loginLog->user_id = $this->id;
                $loginLog->ip = $ipInfo->ip;
            }
            $loginLog->country = $ipInfo->country;
            $loginLog->country_code = $ipInfo->country_code;
            $loginLog->timezone = $ipInfo->timezone;
            $loginLog->location = $ipInfo->location;
            $loginLog->latitude = $ipInfo->latitude;
            $loginLog->longitude = $ipInfo->longitude;
            $loginLog->browser = BrowserDetector::get();
            $loginLog->os = OSDetector::get();
            $loginLog->save();
        }
    }

    public function emptyCart()
    {
        $cartItems = $this->cartItems;
        foreach ($cartItems as $cartItem) {
            $cartItem->delete();
        }
    }

    public function deleteResources()
    {
        $kycVerifications = $this->kycVerifications;
        if ($kycVerifications->count() > 0) {
            foreach ($kycVerifications as $kycVerification) {
                $kycVerification->delete();
            }
        }

        $itemComments = $this->itemComments;
        if ($itemComments->count() > 0) {
            foreach ($itemComments as $itemComment) {
                $itemComment->delete();
            }
        }

        $itemReviews = $this->itemReviews;
        if ($itemReviews->count() > 0) {
            foreach ($itemReviews as $itemReview) {
                $itemReview->delete();
            }
        }

        $transactions = $this->transactions;
        if ($transactions->count() > 0) {
            foreach ($transactions as $transaction) {
                $transaction->delete();
            }
        }

        $tickets = $this->tickets;
        if ($tickets->count() > 0) {
            foreach ($tickets as $ticket) {
                $ticket->delete();
            }
        }

        removeFile($this->avatar);
    }

    public function sendPasswordResetNotification($token)
    {
        $this->notify(new ResetPasswordNotification($token, 'password.reset'));
    }

    public function sendEmailVerificationNotification()
    {
        if (@settings('actions')->email_verification) {
            $this->notify(new VerifyEmailNotification());
        }
    }

    public function kycVerifications()
    {
        return $this->hasMany(KycVerification::class);
    }

    public function tickets()
    {
        return $this->hasMany(Ticket::class);
    }

    public function itemComments()
    {
        return $this->hasMany(ItemComment::class);
    }

    public function itemReviews()
    {
        return $this->hasMany(ItemReview::class);
    }

    public function cartItems()
    {
        return $this->hasMany(CartItem::class);
    }

    public function purchases()
    {
        return $this->hasMany(Purchase::class);
    }

    public function favorites()
    {
        return $this->hasMany(Favorite::class);
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }

    public function refunds()
    {
        return $this->hasMany(Refund::class);
    }

    public function subscription()
    {
        return $this->hasOne(Subscription::class);
    }
}