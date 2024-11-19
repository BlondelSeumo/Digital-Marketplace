<?php

namespace App\Jobs\Admin;

use App\Classes\SendMail;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SendAdminKycPendingNotification implements ShouldQueue
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

        $admins = User::admin()->get();
        foreach ($admins as $admin) {
            SendMail::send($admin->email, 'admin_kyc_pending', [
                "username" => $kycVerification->user->username,
                "kyc_verification_id" => $kycVerification->id,
                "review_link" => route('admin.kyc.kyc-verifications.review', $kycVerification->id),
                "website_name" => @settings('general')->site_name,
            ]);
        }

        $title = translate('KYC Verification Request [#:kyc_verification_id]', ['kyc_verification_id' => $kycVerification->id]);
        $image = asset('images/notifications/kyc.png');
        $link = route('admin.kyc.kyc-verifications.review', $kycVerification->id);
        adminNotify($title, $image, $link);
    }
}