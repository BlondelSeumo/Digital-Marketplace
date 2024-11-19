<?php

namespace App\Livewire\Item;

use App\Models\ItemCommentReply;
use App\Models\ItemCommentReport;
use App\Traits\LivewireToastr;
use Illuminate\Support\Facades\Validator;
use Livewire\Component;

class CommentReport extends Component
{
    use LivewireToastr;

    public $user;

    public $itemCommentReply = null;

    public $report_reason;

    protected $listeners = [
        'reportItemComment' => 'showReportItemCommentModal',
    ];

    public function mount()
    {
        $this->user = authUser();
    }

    public function showReportItemCommentModal($id)
    {
        $itemCommentReply = ItemCommentReply::where('id', $id)->firstOrFail();

        $this->itemCommentReply = $itemCommentReply;

        $this->dispatchBrowserEvent('show-modal', ['id' => 'reportItemCommentModal']);
    }

    public function sendCommentReport()
    {
        $validator = Validator::make(['report_reason' => $this->report_reason], [
            'report_reason' => ['required', 'string', 'max:2000'],
        ]);

        if ($validator->fails()) {
            foreach ($validator->errors()->all() as $error) {
                return $this->toastr('error', $error);
            }
        }

        $itemCommentReportExists = ItemCommentReport::where('item_comment_reply_id', $this->itemCommentReply->id)
            ->where('user_id', $this->user->id)
            ->first();

        if ($itemCommentReportExists) {
            return $this->toastr('error', translate('This comment is under review'));
        }

        $itemCommentReport = new ItemCommentReport();
        $itemCommentReport->user_id = $this->user->id;
        $itemCommentReport->item_comment_reply_id = $this->itemCommentReply->id;
        $itemCommentReport->reason = $this->report_reason;
        $itemCommentReport->save();

        $title = translate('New Item Comment Reported');
        $image = asset('images/notifications/report.png');
        $link = route('admin.reports.item-comments.show', $itemCommentReport->id);
        adminNotify($title, $image, $link);

        $this->report_reason = '';

        $this->emit('refreshItemCommentReplies');

        $this->dispatchBrowserEvent('close-modal', ['id' => 'reportItemCommentModal']);

        return $this->toastr('success', translate('Your report has been sent successfully'));
    }

    public function render()
    {
        return theme_view('livewire.item.comment-report');
    }

}
