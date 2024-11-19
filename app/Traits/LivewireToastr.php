<?php

namespace App\Traits;

trait LivewireToastr
{
    public function toastr(string $type = 'success', string $message = '', array $options = [])
    {
        return $this->dispatchBrowserEvent('alert', [
            'type' => $type,
            'message' => $message,
            'options' => $options,
        ]);
    }
}
