<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AdminNotification;

class NotificationController extends Controller
{
    public function index()
    {
        $notifications = AdminNotification::orderbyDesc('id')->paginate(10);
        return view('admin.notifications', ['notifications' => $notifications]);
    }

    public function view($id)
    {
        $notification = AdminNotification::where('id', $id)->firstOrFail();
        if ($notification->link) {
            $notification->status = AdminNotification::STATUS_READ;
            $notification->update();
            return redirect($notification->link);
        }
        return back();
    }

    public function readAll()
    {
        $notifications = AdminNotification::unread()->get();
        if ($notifications->count() > 0) {
            foreach ($notifications as $notification) {
                $notification->update(['status' => 1]);
            }
            toastr()->success(translate('All notifications marked as read'));
        }
        return back();
    }

    public function deleteRead()
    {
        $notifications = AdminNotification::read()->get();
        if ($notifications->count() > 0) {
            foreach ($notifications as $notification) {
                $notification->delete();
            }
            toastr()->success(translate('Read notifications deleted successfully'));
        }
        return back();
    }
}
