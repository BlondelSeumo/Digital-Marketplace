<?php

namespace App\Http\Controllers\Admin\Settings;

use App\Http\Controllers\Controller;
use App\Models\Extension;
use Illuminate\Http\Request;

class ExtensionController extends Controller
{
    public function index()
    {
        $extensions = Extension::all();
        return view('admin.settings.extensions.index', ['extensions' => $extensions]);
    }

    public function edit(Extension $extension)
    {
        return view('admin.settings.extensions.edit', ['extension' => $extension]);
    }

    public function update(Request $request, Extension $extension)
    {
        foreach ($request->settings as $key => $value) {
            if (!array_key_exists($key, (array) $extension->settings)) {
                toastr()->error(translate('Settings parameter error'));
                return back();
            }
        }

        if ($request->has('status')) {
            foreach ($request->settings as $key => $value) {
                if (empty($value)) {
                    toastr()->error(translate(':key cannot be empty', ['key' => str_replace('_', ucfirst($key))]));
                    return back();
                }
            }
            $request->status = 1;
        } else {
            $request->status = 0;
        }

        $update = $extension->update([
            'status' => $request->status,
            'settings' => $request->settings,
        ]);

        if ($update) {
            $extension->setSettings();
            toastr()->success(translate('Updated Successfully'));
            return back();
        }
    }
}
