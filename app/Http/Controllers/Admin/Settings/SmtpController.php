<?php

namespace App\Http\Controllers\Admin\Settings;

use App\Http\Controllers\Controller;
use App\Models\Settings;
use Illuminate\Http\Request;
use Mail;
use Validator;

class SmtpController extends Controller
{
    public function index()
    {
        return view('admin.settings.smtp');
    }

    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'smtp.mailer' => ['required_if:smtp.status,on', 'in:smtp,sendmail'],
            'smtp.host' => ['required_if:smtp.status,on'],
            'smtp.port' => ['required_if:smtp.status,on'],
            'smtp.username' => ['required_if:smtp.status,on'],
            'smtp.password' => ['required_if:smtp.status,on'],
            'smtp.encryption' => ['required_if:smtp.status,on', 'in:ssl,tls'],
            'smtp.from_email' => ['required_if:smtp.status,on'],
            'smtp.from_name' => ['required_if:smtp.status,on'],
        ]);

        if ($validator->fails()) {
            foreach ($validator->errors()->all() as $error) {toastr()->error($error);}
            return back();
        }

        $data = $request->smtp;
        $data['status'] = ($request->has('smtp.status')) ? 1 : 0;
        $update = Settings::updateSettings('smtp', $data);

        if ($update) {
            setEnv('MAIL_MAILER', $data['mailer']);
            setEnv('MAIL_HOST', $data['host']);
            setEnv('MAIL_PORT', $data['port']);
            setEnv('MAIL_USERNAME', $data['username']);
            setEnv('MAIL_PASSWORD', $data['password'], true);
            setEnv('MAIL_ENCRYPTION', $data['encryption']);
            setEnv('MAIL_FROM_ADDRESS', $data['from_email']);
            setEnv('MAIL_FROM_NAME', $data['from_name'], true);
            toastr()->success(translate('Updated Successfully'));
            return back();
        } else {
            toastr()->error(translate('Updated Error'));
            return back();
        }
    }

    public function test(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => ['required', 'email'],
        ]);

        if ($validator->fails()) {
            foreach ($validator->errors()->all() as $error) {toastr()->error($error);}
            return back()->withInput();
        }

        if (!@settings('smtp')->status) {
            toastr()->error(translate('SMTP is not enabled'));
            return back()->withInput();
        }

        try {
            $email = $request->email;
            Mail::raw('Hi, This is a test mail to ' . $email, function ($message) use ($email) {
                $message->to($email)
                    ->subject('Test mail to ' . $email);
            });
            toastr()->success(translate('Sent successfully'));
            return back();
        } catch (\Exception $e) {
            toastr()->error(translate('Sending failed'));
            return back();
        }
    }
}
