<?php

namespace App\Http\Controllers\Admin\Settings;

use App\Http\Controllers\Controller;
use App\Models\OAuthProvider;
use Illuminate\Http\Request;

class OAuthProviderController extends Controller
{
    public function index()
    {
        $oauthProviders = OAuthProvider::all();
        return view('admin.settings.oauth-providers.index', ['oauthProviders' => $oauthProviders]);
    }

    public function edit(OAuthProvider $oauthProvider)
    {
        return view('admin.settings.oauth-providers.edit', ['oauthProvider' => $oauthProvider]);
    }

    public function update(Request $request, OAuthProvider $oauthProvider)
    {
        foreach ($request->credentials as $key => $value) {
            if (!array_key_exists($key, (array) $oauthProvider->credentials)) {
                toastr()->error(translate('Credentials parameter error'));
                return back();
            }
        }

        if ($request->has('status')) {
            foreach ($request->credentials as $key => $value) {
                if (empty($value)) {
                    toastr()->error(translate(':key cannot be empty', ['key' => str_replace('_', ucfirst($key))]));
                    return back();
                }
            }
            $request->status = 1;
        } else {
            $request->status = 0;
        }

        $update = $oauthProvider->update([
            'status' => $request->status,
            'credentials' => $request->credentials,
        ]);

        if ($update) {
            $oauthProvider->setCredentials();
            toastr()->success(translate('Updated Successfully'));
            return back();
        }
    }
}
