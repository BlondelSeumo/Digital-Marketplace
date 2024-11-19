<?php

namespace App\Services\Captcha;

use Illuminate\Support\Facades\Http;

class GoogleRecaptchaService
{
    protected $captchaProvider;

    public function __construct()
    {
        $this->captchaProvider = captchaProvider('google_recaptcha');
    }

    public function verify($token)
    {
        $response = Http::asForm()->post('https://www.google.com/recaptcha/api/siteverify', [
            'secret' => @$this->captchaProvider->settings->secret_key,
            'response' => $token,
        ]);

        return $response->json()['success'];
    }

    public function render($lang = 'en')
    {
        return '<script src="https://www.google.com/recaptcha/api.js?hl=' . $lang . '" async defer></script>
                <div class="g-recaptcha" data-sitekey="' . @$this->captchaProvider->settings->site_key . '"></div>';
    }
}
