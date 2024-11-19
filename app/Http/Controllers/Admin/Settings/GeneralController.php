<?php

namespace App\Http\Controllers\Admin\Settings;

use App\Http\Controllers\Controller;
use App\Models\Settings;
use Illuminate\Http\Request;
use Str;
use Validator;

class GeneralController extends Controller
{
    public function index()
    {
        return view('admin.settings.general');
    }

    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'general.site_name' => 'required|string|block_patterns|max:255',
            'general.site_url' => 'required|block_patterns|url',
            'general.contact_email' => 'nullable|string|email|block_patterns',
            'general.date_format' => 'required|in:' . implode(',', array_keys(Settings::dateFormats())),
            'general.timezone' => 'required|in:' . implode(',', array_keys(Settings::timezones())),
            'social_links.*' => 'nullable|string|block_patterns|max:50',
            'links.*' => 'nullable|string|block_patterns',
            'seo.title' => 'nullable|string|block_patterns|max:70',
            'seo.description' => 'nullable|string|block_patterns|max:150',
            'seo.keywords' => 'nullable|string|block_patterns|max:200',
        ]);

        if ($validator->fails()) {
            foreach ($validator->errors()->all() as $error) {
                toastr()->error($error);
            }
            return back();
        }

        if ($request->has('action.email_verification') && !@settings('smtp')->status) {
            toastr()->error(translate('SMTP is not enabled'));
            return back()->withInput();
        }

        $requestData = $request->except('_token');

        if ($request->has('actions.contact_page') && empty($requestData['general']['contact_email'])) {
            toastr()->error(translate('Contact email is required to enable contact page'));
            return back()->withInput();
        }

        $requestData['actions'] = [];
        foreach (@settings('actions') as $key => $value) {
            $requestData['actions'][$key] = ($request->has("actions.$key")) ? 1 : 0;
        }

        foreach ($requestData as $key => $value) {
            $update = Settings::updateSettings($key, $value);
            if (!$update) {
                toastr()->error(translate('Updated Error'));
                return back();
            }
        }

        setEnv('APP_NAME', Str::slug($requestData['general']['site_name'], '_'));
        setEnv('APP_URL', $requestData['general']['site_url']);
        setEnv('APP_TIMEZONE', $requestData['general']['timezone'], true);

        toastr()->success(translate('Updated Successfully'));
        return back();
    }
}
