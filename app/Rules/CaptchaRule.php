<?php

namespace App\Rules;

use App\Methods\ReCaptchaValidation;
use Illuminate\Contracts\Validation\Rule;

class CaptchaRule implements Rule
{
    protected $service;

    public function __construct()
    {
        $this->service =  app(ReCaptchaValidation::class)->getService();
    }

    public function passes($attribute, $value)
    {
        if (empty($value)) {
            return false;
        }

        return $this->service->verify($value);
    }

    public function message()
    {
        return __('validation.captcha');
    }
}