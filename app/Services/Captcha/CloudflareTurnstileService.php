<?php

namespace App\Services\Captcha;

use Illuminate\Support\Facades\Http;

class CloudflareTurnstileService
{
    protected $captchaProvider;

    public function __construct()
    {
        $this->captchaProvider = captchaProvider('cloudflare_turnstile');
    }

    public function verify($token)
    {
        $response = Http::asForm()->post('https://challenges.cloudflare.com/turnstile/v0/siteverify', [
            'secret' => @$this->captchaProvider->settings->secret_key,
            'response' => $token,
        ]);

        return $response->json()['success'];
    }

    public function render($lang = 'en')
    {
        return '<script src="https://challenges.cloudflare.com/turnstile/v0/api.js" async defer></script>
                <div class="cf-turnstile" data-theme="light" data-language="' . $lang . '" data-sitekey="' . @$this->captchaProvider->settings->site_key . '"></div>';
    }
}