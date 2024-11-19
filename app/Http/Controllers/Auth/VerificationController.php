<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\VerifiesEmails;
use Illuminate\Http\Request;
use Validator;

class VerificationController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Email Verification Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling email verification for any
    | user that recently registered with the application. Emails may also
    | be re-sent if the user didn't receive the original email message.
    |
     */

    use VerifiesEmails;

    /**
     * Where to redirect users after verification.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('signed')->only('verify');
        $this->middleware('throttle:6,1')->only('verify', 'resend');
    }

    /**
     * Show the email verification notice.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function show(Request $request)
    {
        if (!@settings('actions')->email_verification) {
            return redirect()->route('home');
        } else {
            return $request->user()->hasVerifiedEmail()
            ? redirect($this->redirectPath())
            : theme_view('auth.verify');
        }
    }

    /**
     * Change email address
     *
     * @param  \Illuminate\Http\Request  $request
     */
    public function changeEmail(Request $request)
    {
        $user = authUser();

        $validator = Validator::make($request->all(), [
            'email' => ['required', 'string', 'email', 'indisposable', 'max:100', 'block_patterns', 'unique:users,email,' . $user->id],
        ]);

        if ($validator->fails()) {
            foreach ($validator->errors()->all() as $error) {
                toastr()->error($error);
            }
            return back();
        }

        if ($user->email != $request->email) {
            $update = $user->update(['email' => $request->email]);
            if ($update) {
                $user->sendEmailVerificationNotification();
                toastr()->success(translate('Email has been changed successfully'));
                return back();
            }
        }

        return back();
    }
}
