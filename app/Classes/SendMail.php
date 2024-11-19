<?php

namespace App\Classes;

use App\Mail\GlobalMail;
use Exception;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class SendMail
{
    public static function send($receiver_email, $mail_template_alias, $short_codes, $markdown = null)
    {
        try {
            if (@settings('smtp')->status) {
                $mailTemplate = mailTemplate($mail_template_alias);

                if ($mailTemplate && $mailTemplate->status) {
                    $subject = self::replaceShortCodes($mailTemplate->subject, $short_codes);
                    $body = self::replaceShortCodes($mailTemplate->body, $short_codes);

                    Mail::to($receiver_email)->send(new GlobalMail($subject, $body, $markdown));
                }
            }
        } catch (Exception $e) {
            Log::error($e->getMessage());
        }
    }

    public static function replaceShortCodes($content, $short_codes)
    {
        foreach ($short_codes as $key => $value) {
            $content = str_replace("{{" . $key . "}}", $value, $content);
        }

        return $content;
    }
}
