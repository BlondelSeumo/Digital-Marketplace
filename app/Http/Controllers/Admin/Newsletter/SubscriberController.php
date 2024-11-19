<?php

namespace App\Http\Controllers\Admin\Newsletter;

use App\Exports\NewsletterSubscribersExport;
use App\Http\Controllers\Controller;
use App\Jobs\SendMailToAllSubscribers;
use App\Models\NewsletterSubscriber;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;

class SubscriberController extends Controller
{
    public function index()
    {
        $subscribers = NewsletterSubscriber::query();

        if (request()->filled('search')) {
            $searchTerm = '%' . request('search') . '%';
            $subscribers->where(function ($query) use ($searchTerm) {
                $query->where('id', 'like', $searchTerm)
                    ->OrWhere('email', 'like', $searchTerm)
                    ->OrWhere('country', 'like', $searchTerm);
            });
        }

        if (request()->filled('country')) {
            $subscribers->where('country', request('country'));
        }

        $subscribers = $subscribers->orderbyDesc('id')->paginate(50);
        $subscribers->appends(request()->only(['search', 'country']));

        return view('admin.newsletter.subscribers.index', [
            'subscribers' => $subscribers,
        ]);
    }

    public function sendMail(Request $request)
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

        dispatch(new SendMailToAllSubscribers(
            $request->subject,
            $request->reply_to,
            $request->message
        ));

        toastr()->success(translate('The email has been sent successfully'));
        return back();
    }

    public function export(Request $request)
    {
        return Excel::download(new NewsletterSubscribersExport, 'newsletter-subscribers-' . time() . '.xlsx');
    }

    public function destroy(NewsletterSubscriber $newsletterSubscriber)
    {
        $newsletterSubscriber->delete();

        toastr()->success(translate('Deleted successfully'));
        return back();
    }
}