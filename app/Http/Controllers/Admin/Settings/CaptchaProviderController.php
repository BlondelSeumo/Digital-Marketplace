<?php

namespace App\Http\Controllers\Admin\Settings;

use App\Http\Controllers\Controller;
use App\Models\CaptchaProvider;
use Illuminate\Http\Request;

class CaptchaProviderController extends Controller
{
    public function index()
    {
        $captchaProviders = CaptchaProvider::all();
        return view('admin.settings.captcha-providers.index', [
            'captchaProviders' => $captchaProviders,
        ]);
    }

    public function edit(CaptchaProvider $captchaProvider)
    {
        return view('admin.settings.captcha-providers.edit', [
            'captchaProvider' => $captchaProvider,
        ]);
    }

    public function update(Request $request, CaptchaProvider $captchaProvider)
    {
        foreach ($request->settings as $key => $value) {
            if (!array_key_exists($key, (array) $captchaProvider->settings)) {
                toastr()->error(translate('Settings parameter error'));
                return back();
            }
        }

        if ($request->has('status')) {
            foreach ($request->settings as $key => $value) {
                if (empty($value)) {
                    toastr()->error(translate(':key cannot be empty', ['key' => str_replace('_', ucfirst($key))]));
                    return back();
                }
            }
            $request->status = 1;
        } else {
            $request->status = 0;
        }

        $update = $captchaProvider->update([
            'status' => $request->status,
            'settings' => $request->settings,
        ]);

        if ($update) {
            toastr()->success(translate('Updated Successfully'));
            return back();
        }
    }

    public function makeDefault(Request $request, CaptchaProvider $captchaProvider)
    {
        abort_if($captchaProvider->isDefault(), 401);

        if (!$captchaProvider->status) {
            toastr()->error(translate('The selected captcha provider is not active'));
            return back();
        }

        $captchaProviders = CaptchaProvider::default()->get();
        foreach ($captchaProviders as $provider) {
            $provider->is_default = CaptchaProvider::NOT_DEFAULT;
            $provider->update();
        }

        $captchaProvider->is_default = CaptchaProvider::DEFAULT;
        $captchaProvider->update();

        toastr()->success(translate('The default captcha providers has been updated'));
        return back();
    }
}
