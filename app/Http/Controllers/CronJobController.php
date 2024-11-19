<?php

namespace App\Http\Controllers;

use App\Models\Settings;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Validator;

class CronJobController extends Controller
{
    public function run(Request $request)
    {
        ini_set('max_execution_time', 0);

        $cronJobSettings = settings('cronjob');

        if (@$cronJobSettings->key) {

            $validator = Validator::make($request->all(), [
                'key' => ['required', 'string'],
            ]);

            if ($validator->fails()) {
                foreach ($validator->errors()->all() as $error) {
                    return response()->json([
                        'status' => 'error',
                        'message' => $error,
                    ], 403);
                }
            }

            if (@$cronJobSettings->key != $request->key) {
                return response()->json([
                    'status' => 'error',
                    'message' => translate('Invalid Cron Job Key'),
                ], 403);
            }
        }

        Artisan::call('schedule:run');

        Settings::updateSettings('cronjob', ['last_execution' => Carbon::now()]);

        return response()->json([
            'status' => 'success',
            'message' => translate('Cron Job executed successfully'),
        ], 200);
    }
}
