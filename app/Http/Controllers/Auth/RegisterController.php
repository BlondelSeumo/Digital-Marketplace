<?php

namespace App\Http\Controllers\Auth;

use App\Events\Registered;
use App\Http\Controllers\Controller;
use App\Methods\ReCaptchaValidation;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
     */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
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
        $this->middleware('guest');
    }

    /**
     * Show the application registration form.
     *
     * @return \Illuminate\View\View
     */
    public function showRegistrationForm(Request $request)
    {
        return theme_view('auth.register');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        $rules = [
            'firstname' => ['required', 'string', 'block_patterns', 'max:50'],
            'lastname' => ['required', 'string', 'block_patterns', 'max:50'],
            'username' => ['required', 'string', 'min:6', 'max:50', 'username', 'alpha_dash', 'block_patterns', 'unique:users'],
            'email' => ['required', 'string', 'email', 'indisposable', 'block_patterns', 'max:100', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ] + app(ReCaptchaValidation::class)->validate();

        if (@settings('links')->terms_of_use_link) {
            $rules['terms'] = ['required'];
        }

        return Validator::make($data, $rules);
    }

    /**
     * Before register a new user
     *
     * @return //redirect
     */
    public function register(Request $request)
    {
        $data = $request->all();
        $this->validator($data)->validate();
        $user = $this->create($data);
        event(new Registered($user));
        $this->guard()->login($user);
        return $this->registered($request, $user)
        ?: redirect($this->redirectPath());
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    protected function create(array $data)
    {
        $user = User::create([
            'firstname' => $data['firstname'],
            'lastname' => $data['lastname'],
            'username' => $data['username'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);

        $user->registerLoginLog();
        self::adminNotify($user);

        return $user;
    }

    /**
     * Create a new admin notification
     *
     * @return // save data
     */
    public static function adminNotify($user)
    {
        $title = translate(':username has registered', ['username' => $user->getName()]);
        $image = $user->getAvatar();
        $link = route('admin.members.users.edit', $user->id);
        return adminNotify($title, $image, $link);
    }
}