<?php

namespace App\Http\Controllers\User;

use App\Classes\Country;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class SettingsController extends Controller
{
    public function index()
    {
        $qr_image = null;
        if (!authUser()->google2fa_status) {
            $google2fa = app('pragmarx.google2fa');
            $secretKey = encrypt($google2fa->generateSecretKey());
            authUser()->update(['google2fa_secret' => $secretKey]);
            $qr_image = $google2fa->getQRCodeInline(@settings('general')->site_name, authUser()->email, authUser()->google2fa_secret);
        }

        return theme_view('user.settings', [
            'user' => authUser(),
            'qr_image' => $qr_image,
        ]);
    }

    public function detailsUpdate(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'firstname' => ['required', 'string', 'block_patterns', 'max:50'],
            'lastname' => ['required', 'string', 'block_patterns', 'max:50'],
            'username' => ['required', 'string', 'block_patterns', 'username', 'max:100', 'unique:users,username,' . authUser()->id],
            'email' => ['required', 'string', 'block_patterns', 'email', 'max:100', 'unique:users,email,' . authUser()->id],
            'address_line_1' => ['required', 'string', 'max:255', 'block_patterns'],
            'address_line_2' => ['nullable', 'string', 'max:255', 'block_patterns'],
            'city' => ['required', 'string', 'max:150', 'block_patterns'],
            'state' => ['required', 'string', 'max:150', 'block_patterns'],
            'zip' => ['required', 'string', 'max:100', 'block_patterns'],
            'country' => ['required', 'string', 'in:' . implode(',', array_keys(Country::all()))],
        ]);

        if ($validator->fails()) {
            foreach ($validator->errors()->all() as $error) {
                toastr()->error($error);
            }
            return back();
        }

        $user = authUser();

        $verify = (@settings('actions')->email_verification && $user->email != $request->email) ? 1 : 0;

        $country = $request->country ?? null;

        $address = [
            'line_1' => $request->address_line_1,
            'line_2' => $request->address_line_2,
            'city' => $request->city,
            'state' => $request->state,
            'zip' => $request->zip,
            'country' => $country,
        ];

        if ($request->has('avatar')) {
            $avatar = $request->file('avatar');
            $avatar = imageUpload($avatar, 'images/avatars/users/', '120x120', null, $user->avatar);
        } else {
            $avatar = $user->avatar;
        }

        $user->firstname = $request->firstname;
        $user->lastname = $request->lastname;
        $user->username = $request->username;
        $user->email = $request->email;
        $user->address = $address;
        $user->avatar = $avatar;
        $user->update();

        if ($verify) {
            $user->forceFill(['email_verified_at' => null])->save();
            $user->sendEmailVerificationNotification();
        }

        toastr()->success(translate('Account details has been updated successfully'));
        return back();
    }

    public function subscriptionCancel()
    {
        $user = authUser();
        $subscription = $user->subscription;
        $subscription->delete();

        toastr()->success(translate('Your subscription has been cancelled'));
        return back();
    }

    public function passwordUpdate(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'current-password' => ['required'],
            'new-password' => ['required', 'string', 'min:8', 'confirmed'],
            'new-password_confirmation' => ['required'],
        ]);

        if ($validator->fails()) {
            foreach ($validator->errors()->all() as $error) {
                toastr()->error($error);
            }
            return back();
        }

        $user = authUser();

        if (!(Hash::check($request->get('current-password'), $user->password))) {
            toastr()->error(translate('Your current password does not matches with the password you provided'));
            return back();
        }

        if (strcmp($request->get('current-password'), $request->get('new-password')) == 0) {
            toastr()->error(translate('New Password cannot be same as your current password. Please choose a different password'));
            return back();
        }

        $user->password = bcrypt($request->get('new-password'));
        $user->update();

        toastr()->success(translate('Account password has been changed successfully'));
        return back();
    }

    public function towFactorEnable(Request $request)
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

        $user = authUser();

        $google2fa = app('pragmarx.google2fa');
        $valid = $google2fa->verifyKey($user->google2fa_secret, $request->otp_code);
        if ($valid == false) {
            toastr()->error(translate('Invalid OTP code'));
            return back();
        }

        $update2FaStatus = $user->update(['google2fa_status' => true]);
        if ($update2FaStatus) {
            session()->put('2fa', hash_encode($user->id));
            toastr()->success(translate('2FA Authentication has been enabled successfully'));
            return back();
        }

    }

    public function towFactorDisable(Request $request)
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

        $user = authUser();

        $google2fa = app('pragmarx.google2fa');
        $valid = $google2fa->verifyKey($user->google2fa_secret, $request->otp_code);
        if ($valid == false) {
            toastr()->error(translate('Invalid OTP code'));
            return back();
        }

        $update2FaStatus = $user->update(['google2fa_status' => false]);
        if ($update2FaStatus) {
            if ($request->session()->has('2fa')) {
                session()->forget('2fa');
            }
            toastr()->success(translate('2FA Authentication has been disabled successfully'));
            return back();
        }
    }

}
