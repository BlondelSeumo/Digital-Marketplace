<?php

namespace App\Jobs;

use App\Classes\SendMail;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SendKycApprovedNotification implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $kycVerification;

    public function __construct($kycVerification)
    {
        $this->kycVerification = $kycVerification;
    }

    public function handle()
    {
        $kycVerification = $this->kycVerification;
        $user = $kycVerification->user;

        SendMail::send($user->email, 'kyc_verification_approved', [
            'username' => $user->username,
            'website_name' => @settings('general')->site_name,
        ]);
    }
}
