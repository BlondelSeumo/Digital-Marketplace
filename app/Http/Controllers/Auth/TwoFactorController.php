<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;

class TwoFactorController extends Controller
{
    public function show2FaVerifyForm()
    {
        if (!authUser()->google2fa_status || session()->has('2fa')
            && session('2fa') == hash_encode(authUser()->id)) {
            return redirect()->route('home');
        }
        return theme_view('auth.2fa');
    }

    public function verify2fa(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'otp_code' => ['required', 'numeric'],
        ]);

        if ($validator->fails()) {
            foreach ($validator->errors()->all() as $error) {
                toastr()->error($error);
            }
            return back();
        }

        $google2fa = app('pragmarx.google2fa');
        $valid = $google2fa->verifyKey(authUser()->google2fa_secret, $request->otp_code);
        if ($valid == false) {
            toastr()->error(translate('Invalid OTP code'));
            return back();
        }

        session()->put('2fa', hash_encode(authUser()->id));
        return redirect()->route('home');
    }
}
