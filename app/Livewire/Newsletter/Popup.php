<?php

namespace App\Livewire\Newsletter;

use App\Classes\Newsletter;
use App\Traits\LivewireToastr;
use Exception;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Validator;
use Livewire\Component;

class Popup extends Component
{
    use LivewireToastr;

    public $email;

    protected $listeners = [
        'newsletterRefresh' => '$refresh',
    ];

    public function remindLater()
    {
        Cookie::queue('newsletter_reminder', true, (@settings('newsletter')->popup_reminder_time * 60));
        $this->dispatchBrowserEvent('close-modal', ['id' => 'newsletterModal']);
    }

    public function subscribe()
    {
        $validator = Validator::make(['email' => $this->email], [
            'email' => ['required', 'string', 'email', 'indisposable'],
        ]);

        if ($validator->fails()) {
            foreach ($validator->errors()->all() as $error) {
                return $this->toastr('error', $error);
            }
        }

        try {
            if (!Newsletter::isSubscribed($this->email)) {
                Newsletter::subscribe($this->email);
            }

            Cookie::queue(Cookie::forever('newsletter_subscribed', true));

            $this->email = '';
            $this->dispatchBrowserEvent('close-modal', ['id' => 'newsletterModal']);
            $this->emit('newsletterRefresh');

            return $this->toastr('success', translate('You have successfully subscribed'));
        } catch (Exception $e) {
            return $this->toastr('error', $e->getMessage());
        }
    }

    public function render()
    {
        return theme_view('livewire.newsletter.popup');
    }
}