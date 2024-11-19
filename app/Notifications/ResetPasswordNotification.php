<?php

namespace App\Notifications;

use App\Classes\SendMail;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Mail;

class ResetPasswordNotification extends Notification
{
    use Queueable;

    public $token;

    public $route;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($token, $route)
    {
        $this->token = $token;
        $this->route = $route;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        $mailTemplate = mailTemplate('password_reset');

        $shortCodes = [
            'link' => url(url('/') . route($this->route, ['token' => $this->token, 'email' => $notifiable->getEmailForPasswordReset()], false)),
            'expiry_time' => config('auth.passwords.' . config('auth.defaults.passwords') . '.expire'),
            'website_name' => @settings('general')->site_name,
        ];

        $subject = SendMail::replaceShortCodes($mailTemplate->subject, $shortCodes);
        $body = SendMail::replaceShortCodes($mailTemplate->body, $shortCodes);

        return (new MailMessage)
            ->subject($subject)
            ->markdown('emails.default', ['body' => $body]);
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
