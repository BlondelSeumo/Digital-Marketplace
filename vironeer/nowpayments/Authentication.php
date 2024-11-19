<?php

namespace Vironeer\NOWPayments;

class Authentication
{
    public static function authenticate(string $content, string $receivedHmac, string $ipnSecret): bool
    {
        if (!empty($content) and !empty($receivedHmac) and !empty($ipnSecret)) {

            $data = json_decode($content, true);
            ksort($data);
            $json = json_encode($data);

            if ($json !== false and !empty($json)) {

                $hmac = hash_hmac('sha512', $json, $ipnSecret);

                if ($receivedHmac == $hmac) {
                    return true;
                }

            }
        }

        return false;
    }
}
