<?php

namespace App\Http\Controllers\Admin\Settings;

use App\Http\Controllers\Controller;
use App\Models\Settings;
use Illuminate\Http\Request;
use Validator;

class TicketController extends Controller
{
    public function index()
    {
        return view('admin.settings.ticket');
    }

    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'ticket.file_types' => 'required|string',
            'ticket.max_files' => 'required|integer|min:1|max:1000',
            'ticket.max_file_size' => 'required|integer|min:1',
        ]);

        if ($validator->fails()) {
            foreach ($validator->errors()->all() as $error) {
                toastr()->error($error);
            }
            return back();
        }

        $requestData = $request->except('_token');

        $update = Settings::updateSettings('ticket', $requestData['ticket']);
        if (!$update) {
            toastr()->error(translate('Updated Error'));
            return back();
        }

        toastr()->success(translate('Updated Successfully'));
        return back();
    }
}
