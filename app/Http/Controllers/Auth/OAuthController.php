<?php

namespace App\Http\Controllers\Auth;

use App\Events\Registered;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Controller;
use App\Methods\ReCaptchaValidation;
use App\Models\OAuthProvider;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Auth;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Laravel\Socialite\Facades\Socialite;
use Validator;

class OAuthController extends Controller
{
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Redirect the user to the OAuth provider for authentication.
     *
     * @param  string  $provider
     * @return \Illuminate\Http\RedirectResponse
     *
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException
     */
    public function redirectToProvider($provider)
    {
        $oauthProvider = OAuthProvider::where('alias', $provider)->firstOrFail();
        return Socialite::driver($oauthProvider->alias)->redirect();
    }

    /**
     * Handles the callback from the OAuth provider and creates or logs in the user.
     *
     * @param Request $request
     * @param string $provider
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException
     */
    public function handleProviderCallback(Request $request, $provider)
    {
        try {
            $oauthProvider = OAuthProvider::where('alias', $provider)->firstOrFail();
            $socialUser = Socialite::driver($oauthProvider->alias)->user();

            $id = $oauthProvider->alias == "envato" ? strtolower($socialUser->user['username']) : $socialUser->getId();
            $name = explode(' ', $socialUser->getName());
            $email = $socialUser->getEmail();

            $userExists = User::where($oauthProvider->alias . '_id', $id)->first();
            if ($userExists) {
                Auth::login($userExists);
                $userExists->registerLoginLog();
                return redirect($this->redirectTo);
            }

            if (!@settings('actions')->registration) {
                toastr()->error(translate('Registration is currently disabled.'));
                return redirect()->route('login');
            }

            if ($email) {
                $emailExists = User::where('email', $email)->first();
                if ($emailExists) {
                    $email = null;
                }
            }

            $user = User::create([
                'firstname' => $name[0] ?? null,
                'lastname' => $name[1] ?? null,
                'email' => $email,
                $oauthProvider->alias . '_id' => $id,
            ]);

            if ($user) {
                if ($user->email) {
                    $user->forceFill(['email_verified_at' => Carbon::now()])->save();
                }

                event(new Registered($user));

                Auth::login($user);
                $user->registerLoginLog();
                return redirect($this->redirectTo);
            }

        } catch (\Exception $e) {
            toastr()->error(translate('Authentication failed. Please try again later.'));
            return redirect()->route('login');
        }
    }

    /**
     * Display the complete form for OAuth authentication.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function showCompleteForm()
    {
        if (authUser()->isDataCompleted()) {
            return redirect($this->redirectTo);
        }
        return theme_view('auth.oauth.complete');
    }

    /**
     * Complete the user profile update process.
     *
     * @param  Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function complete(Request $request)
    {
        $user = authUser();

        $rules = [
            'firstname' => ['required', 'string', 'block_patterns', 'max:50'],
            'lastname' => ['required', 'string', 'block_patterns', 'max:50'],
            'username' => ['required', 'string', 'min:6', 'max:50', 'username', 'alpha_dash', 'block_patterns', 'unique:users,username,' . $user->id],
            'email' => ['required', 'string', 'email', 'indisposable', 'block_patterns', 'max:100', 'unique:users,email,' . $user->id],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ] + app(ReCaptchaValidation::class)->validate();

        if (@settings('links')->terms_of_use_link) {
            $rules['terms'] = ['required'];
        }

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            foreach ($validator->errors()->all() as $error) {
                toastr()->error($error);
            }
            return back();
        }

        $verify = (@settings('actions')->email_verification && $user->email != $request->email) ? 1 : 0;

        $update = $user->update([
            'firstname' => $request->firstname,
            'lastname' => $request->lastname,
            'username' => $request->username,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        if ($update) {
            if ($verify) {
                $user->forceFill(['email_verified_at' => null])->save();
                $user->sendEmailVerificationNotification();
            }

            RegisterController::adminNotify($user);
            return redirect($this->redirectTo);
        }
    }
}