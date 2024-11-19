<?php

namespace App\Methods;

use File;

class Dotenv
{
    public function setKey($key, $value, $quote = false)
    {
        $envFile = base_path('.env');
        $env = file_get_contents($envFile);
        if ($quote) {
            $value = '"' . addcslashes($value, '"') . '"';
        }
        $pattern = "/^{$key}=(.*)$/m";
        if (preg_match($pattern, $env)) {
            $env = preg_replace($pattern, "{$key}={$value}", $env);
        } else {
            $env .= "{$key}={$value}\n";
        }
        File::put($envFile, $env);
        return true;
    }
}