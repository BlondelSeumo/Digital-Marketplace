<?php

namespace App\View\Components;

use Illuminate\View\Component;

class Announcement extends Component
{
    public function render()
    {
        return theme_view('components.announcement');
    }
}