<?php

namespace App\View\Components;

use App\Methods\ReCaptchaValidation;
use Illuminate\Support\Str;
use Illuminate\View\Component;

class Captcha extends Component
{
    public function render()
    {
        $captchaProvider = app(ReCaptchaValidation::class)->getDefaultCaptchaProvider();

        if ($captchaProvider) {
            $class = Str::studly($captchaProvider->alias) . 'Service';
            $service = new ("App\\Services\\Captcha\\{$class}");
            $captcha = '<div class="mb-3">' . $service->render(getLocale()) . '</div>';

            return view('components.captcha', [
                'captcha' => $captcha,
            ]);
        }
    }
}
