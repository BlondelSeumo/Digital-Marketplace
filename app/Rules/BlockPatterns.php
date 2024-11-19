<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class BlockPatterns implements Rule
{
    public function passes($attribute, $value)
    {
        if ($value === null) {
            return true;
        }

        $strippedValue = strip_tags($value);
        if ($strippedValue !== $value) {
            return false;
        }

        if (preg_match('/\{\{[^}]*\}\}|{!![^}]*!!}|<\?php|\{\}|\{[^}]*\}/', $value)) {
            return false;
        }

        return true;
    }

    public function message()
    {
        return __('validation.block_patterns');
    }
}
