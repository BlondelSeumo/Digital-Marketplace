<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Methods\ReCaptchaValidation;
use App\Models\HomeSection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class HomeController extends Controller
{
    public function index()
    {
        if (@settings('maintenance')->status && !request()->hasCookie('maintenance')) {
            return theme_view('maintenance');
        } else {
            $homeSections = HomeSection::active()->get();
            return theme_view('home', ['homeSections' => $homeSections]);
        }
    }

    public function maintenanceUnlock(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'password' => ['required', 'string'],
        ] + app(ReCaptchaValidation::class)->validate());

        if ($validator->fails()) {
            foreach ($validator->errors()->all() as $error) {
                toastr()->error($error);
            }
            return back()->withInput();
        }

        if (!Hash::check($request->password, @settings('maintenance')->password)) {
            toastr()->error(translate('Incorrect Password'));
            return back();
        }

        Cookie::queue('maintenance', true, 43200);
        return back();
    }
}
