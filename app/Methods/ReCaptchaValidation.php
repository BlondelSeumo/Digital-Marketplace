<?php

namespace App\Methods;

use App\Models\CaptchaProvider;
use App\Rules\CaptchaRule;
use App\Services\Captcha\CloudflareTurnstileService;
use App\Services\Captcha\GoogleRecaptchaService;
use App\Services\Captcha\HcaptchaService;
use InvalidArgumentException;

class ReCaptchaValidation
{
    public function getService()
    {
        $captchaProvider = $this->getDefaultCaptchaProvider();

        return $this->resolveCaptchaService($captchaProvider);
    }

    public function validate()
    {
        $captchaProvider = $this->getDefaultCaptchaProvider();

        if ($captchaProvider) {
            $captchaResponseKey = $this->getCaptchaResponseKey($captchaProvider->alias);
            return [$captchaResponseKey => ['required', new CaptchaRule]];
        }

        return [];
    }

    private function resolveCaptchaService($captchaProvider)
    {
        if (!$captchaProvider) {
            throw new InvalidArgumentException(translate('Invalid captcha provider'));
        }

        switch ($captchaProvider->alias) {
            case 'google_recaptcha':
                return app(GoogleRecaptchaService::class);
            case 'hcaptcha':
                return app(HcaptchaService::class);
            case 'cloudflare_turnstile':
                return app(CloudflareTurnstileService::class);
            default:
                throw new InvalidArgumentException(translate('Invalid captcha provider'));
        }
    }

    public function getDefaultCaptchaProvider()
    {
        return CaptchaProvider::active()->default()->first();
    }

    private function getCaptchaResponseKey(string $alias): string
    {
        switch ($alias) {
            case 'google_recaptcha':
                return 'g-recaptcha-response';
            case 'hcaptcha':
                return 'h-captcha-response';
            case 'cloudflare_turnstile':
                return 'cf-turnstile-response';
            default:
                throw new InvalidArgumentException(translate('Invalid captcha provider'));
        }
    }
}
