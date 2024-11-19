<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Ad;
use Illuminate\Http\Request;

class AdController extends Controller
{
    public function index()
    {
        $ads = Ad::all();
        return view('admin.ads.index', ['ads' => $ads]);
    }

    public function edit($id)
    {
        $ad = Ad::findOrFail($id);
        return view('admin.ads.edit', ['ad' => $ad]);
    }

    public function update(Request $request, Ad $ad)
    {
        if ($request->has('status') && is_null($request->code)) {
            toastr()->error(translate('The code cannot be empty'));
            return back();
        }

        $request->status = ($request->has('status')) ? 1 : 0;

        $ad->code = $request->code;
        $ad->status = $request->status;
        $ad->update();

        toastr()->success(translate('Updated Successfully'));
        return back();
    }
}
