<?php

namespace App\Http\Controllers\Admin\Members;

use App\Classes\Country;
use App\Http\Controllers\Controller;
use App\Models\Statement;
use App\Models\User;
use App\Models\UserLoginLog;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Validator;

class UserController extends Controller
{
    public function index()
    {
        $counters['active'] = User::active()->count();
        $counters['banned'] = User::banned()->count();

        $counters['kyc_verified'] = User::kycVerified()->count();
        $counters['kyc_unverified'] = User::kycUnVerified()->count();

        $counters['email_verified'] = User::emailVerified()->count();
        $counters['email_unverified'] = User::emailUnVerified()->count();

        $users = User::user();

        if (request()->filled('search')) {
            $searchTerm = '%' . request('search') . '%';
            $users->where(function ($query) use ($searchTerm) {
                $query->where('firstname', 'like', $searchTerm)
                    ->orWhere('lastname', 'like', $searchTerm)
                    ->orWhere('username', 'like', $searchTerm)
                    ->orWhere('email', 'like', $searchTerm)
                    ->orWhere('address', 'like', $searchTerm)
                    ->orWhere('profile_heading', 'like', $searchTerm)
                    ->orWhere('profile_description', 'like', $searchTerm)
                    ->orWhere('profile_contact_email', 'like', $searchTerm)
                    ->orWhere('profile_social_links', 'like', $searchTerm)
                    ->orWhere('facebook_id', 'like', $searchTerm)
                    ->orWhere('google_id', 'like', $searchTerm);
            });
        }

        if (request()->filled('account_status')) {
            $users->where('status', request('account_status'));
        }

        if (request()->filled('kyc_status')) {
            $users->where('kyc_status', request('kyc_status'));
        }

        if (request()->filled('email_status')) {
            if (request('email_status') == 1) {
                $users->whereNotNull('email_verified_at');
            } else {
                $users->whereNull('email_verified_at');
            }
        }

        $users = $users->orderbyDesc('id')->paginate(50);
        $users->appends(request()->only(['search', 'account_status', 'kyc_status', 'email_status']));

        return view('admin.members.users.index', [
            'counters' => $counters,
            'users' => $users,
        ]);
    }

    public function create()
    {
        return view('admin.members.users.create');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'firstname' => ['required', 'string', 'block_patterns', 'max:50'],
            'lastname' => ['required', 'string', 'block_patterns', 'max:50'],
            'username' => ['required', 'string', 'min:6', 'alpha_dash', 'username', 'block_patterns', 'max:50', 'unique:users'],
            'email' => ['required', 'string', 'email', 'indisposable', 'block_patterns', 'max:100', 'unique:users'],
            'password' => ['required', 'string', 'min:8'],
        ]);

        if ($validator->fails()) {
            foreach ($validator->errors()->all() as $error) {
                toastr()->error($error);
            }
            return back()->withInput();
        }

        $user = User::create([
            'firstname' => $request->firstname,
            'lastname' => $request->lastname,
            'username' => $request->username,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        if ($user) {
            if (@settings('actions')->email_verification) {
                $user->forceFill(['email_verified_at' => Carbon::now()])->save();
            }
            toastr()->success(translate('Created Successfully'));
            return redirect()->route('admin.members.users.edit', $user->id);
        }
    }

    public function edit(User $user)
    {
        return view('admin.members.users.edit', $this->sharedData($user));
    }

    public function update(Request $request, User $user)
    {
        $validator = Validator::make($request->all(), [
            'avatar' => ['nullable', 'image', 'mimes:png,jpg,jpeg', 'max:2048'],
            'firstname' => ['required', 'string', 'block_patterns', 'max:50'],
            'lastname' => ['required', 'string', 'block_patterns', 'max:50'],
            'username' => ['required', 'string', 'min:6', 'max:50', 'username', 'block_patterns', 'unique:users,username,' . $user->id],
            'email' => ['required', 'string', 'email', 'indisposable', 'block_patterns', 'max:100', 'unique:users,email,' . $user->id],
            'address_line_1' => ['nullable', 'max:255'],
            'address_line_2' => ['nullable', 'max:255'],
            'city' => ['nullable', 'max:150'],
            'state' => ['nullable', 'max:150'],
            'zip' => ['nullable', 'max:100'],
            'country' => ['nullable', 'string', 'in:' . implode(',', array_keys(Country::all()))],
            'exclusivity' => ['nullable', 'string', 'in:exclusive,non_exclusive'],
        ]);

        if ($validator->fails()) {
            foreach ($validator->errors()->all() as $error) {
                toastr()->error($error);
            }
            return back();
        }

        if ($request->has('avatar')) {
            $avatar = imageUpload($request->file('avatar'), 'images/avatars/', '120x120', null, $user->avatar);
        } else {
            $avatar = $user->avatar;
        }

        $country = $request->country ?? null;

        $address = [
            'line_1' => $request->address_line_1,
            'line_2' => $request->address_line_2,
            'city' => $request->city,
            'state' => $request->state,
            'zip' => $request->zip,
            'country' => $country,
        ];

        $user->firstname = $request->firstname;
        $user->lastname = $request->lastname;
        $user->username = $request->username;
        $user->email = $request->email;
        $user->address = $address;
        $user->avatar = $avatar;
        $user->update();

        toastr()->success(translate('Updated Successfully'));
        return back();
    }

    public function destroy(User $user)
    {
        $user->deleteResources();
        $user->delete();
        toastr()->success(translate('Deleted Successfully'));
        return back();
    }

    public function sendMail(Request $request, User $user)
    {
        $validator = Validator::make($request->all(), [
            'subject' => ['required', 'string', 'block_patterns'],
            'reply_to' => ['required', 'email', 'block_patterns'],
            'message' => ['required', 'string'],
        ]);

        if ($validator->fails()) {
            foreach ($validator->errors()->all() as $error) {
                toastr()->error($error);
            }
            return back();
        }

        if (!@settings('smtp')->status) {
            toastr()->error(translate('SMTP is not enabled'));
            return back()->withInput();
        }

        try {
            $email = $user->email;
            $subject = $request->subject;
            $replyTo = $request->reply_to;
            $msg = $request->message;
            \Mail::send([], [], function ($message) use ($msg, $email, $subject, $replyTo) {
                $message->to($email)
                    ->replyTo($replyTo)
                    ->subject($subject)
                    ->html($msg);
            });
            toastr()->success(translate('Sent successfully'));
            return back();
        } catch (Exception $e) {
            toastr()->error(translate('Sent error'));
            return back();
        }
    }

    public function showActionsForm(User $user)
    {
        return view('admin.members.users.actions', $this->sharedData($user));
    }

    public function updateActions(Request $request, User $user)
    {
        $request->status = ($request->has('status')) ? 1 : 0;
        $request->kyc_status = ($request->has('kyc_status')) ? 1 : 0;

        $google2faStatus = 0;
        if ($request->has('google2fa_status')) {
            if (!$user->google2fa_status) {
                toastr()->error(translate('Two-Factor authentication cannot activated from admin side'));
                return back();
            } else {
                $google2faStatus = 1;
            }
        }

        $user->kyc_status = $request->kyc_status;
        $user->google2fa_status = $google2faStatus;
        $user->status = $request->status;
        $user->update();

        $emailVerifiedAt = ($request->has('email_status')) ? Carbon::now() : null;
        $user->forceFill(['email_verified_at' => $emailVerifiedAt])->save();

        toastr()->success(translate('Updated Successfully'));
        return back();
    }

    public function wallet(User $user)
    {
        return view('admin.members.users.wallet', $this->sharedData($user));
    }

    public function walletUpdate(Request $request, User $user)
    {
        $validator = Validator::make($request->all(), [
            'type' => ['required', 'string', 'in:credit,debit'],
            'amount' => ['required', 'regex:/^\d*(\.\d{2})?$/'],
            'title' => ['required', 'string', 'max:255'],

        ]);

        if ($validator->fails()) {
            foreach ($validator->errors()->all() as $error) {
                toastr()->error($error);
            }
            return back()->withInput();
        }

        $type = null;
        if ($request->type == "credit") {
            $user->increment('balance', $request->amount);
            $type = Statement::TYPE_CREDIT;
            toastr()->success(translate('Credited Successfully'));
        } elseif ($request->type == "debit") {
            $user->decrement('balance', $request->amount);
            $type = Statement::TYPE_DEBIT;
            toastr()->success(translate('Debited Successfully'));
        }

        if ($type) {
            $saleStatement = new Statement();
            $saleStatement->user_id = $user->id;
            $saleStatement->title = $request->title;
            $saleStatement->amount = $request->amount;
            $saleStatement->type = $type;
            $saleStatement->save();
        }

        return back();
    }

    public function showPasswordForm(User $user)
    {
        return view('admin.members.users.password', $this->sharedData($user));
    }

    public function updatePassword(Request $request, User $user)
    {
        $validator = Validator::make($request->all(), [
            'new-password' => ['required', 'string', 'min:6', 'confirmed'],
            'new-password_confirmation' => ['required'],
        ]);

        if ($validator->fails()) {
            foreach ($validator->errors()->all() as $error) {
                toastr()->error($error);
            }
            return back();
        }

        $update = $user->update([
            'password' => bcrypt($request->get('new-password')),
        ]);

        if ($update) {
            toastr()->success(translate('Updated Successfully'));
            return back();
        }
    }

    public function loginLogs(User $user)
    {
        $loginLogs = UserLoginLog::where('user_id', $user->id)->orderbyDesc('id')->get();
        return view('admin.members.users.login-logs', $this->sharedData($user) + [
            'loginLogs' => $loginLogs,
        ]);
    }

    private function sharedData($user)
    {
        $user = User::where('id', $user->id)
            ->withCount(['purchases' => function ($query) {
                $query->active();
            }])->firstOrFail();

        $counters['total_transactions_amount'] = $user->transactions()->paid()->sum('total');

        return [
            'user' => $user,
            'counters' => $counters,
        ];
    }
}