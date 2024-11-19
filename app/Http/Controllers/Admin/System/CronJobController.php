<?php

namespace App\Http\Controllers\Admin\System;

use App\Http\Controllers\Controller;
use App\Models\Settings;

class CronJobController extends Controller
{
    public function index()
    {
        return view('admin.system.cronjob');
    }

    public function keyGenerate()
    {
        Settings::updateSettings('cronjob', ['key' => hash_encode(time())]);
        toastr()->success(translate('Cron Job key generated successfully'));
        return back();
    }

    public function keyRemove()
    {
        if (@settings('cronjob')->key) {
            Settings::updateSettings('cronjob', ['key' => '']);
            toastr()->success(translate('Cron Job key removed successfully'));
        }
        return back();
    }
}
