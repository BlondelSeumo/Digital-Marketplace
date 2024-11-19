<?php

namespace App\Services\Captcha;

use Illuminate\Support\Facades\Http;

class HcaptchaService
{
    protected $captchaProvider;

    public function __construct()
    {
        $this->captchaProvider = captchaProvider('hcaptcha');
    }

    public function verify($token)
    {
        $response = Http::asForm()->post('https://hcaptcha.com/siteverify', [
            'secret' => @$this->captchaProvider->settings->secret_key,
            'response' => $token,
        ]);

        return $response->json()['success'];
    }

    public function render($lang = 'en')
    {
        return '<script src="https://hcaptcha.com/1/api.js?hl=' . $lang . '" async defer></script>
                <div class="h-captcha" data-sitekey="' . @$this->captchaProvider->settings->site_key . '"></div>';
    }
}
