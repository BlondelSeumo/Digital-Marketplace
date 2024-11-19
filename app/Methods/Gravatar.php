<?php

namespace App\Methods;

class Gravatar
{
    public static function get($email = null)
    {
        $avatar = "https://www.gravatar.com/avatar";
        if ($email) {
            $avatar = $avatar . "/" . md5($email);
        }
        return $avatar . "?d=retro";
    }
}