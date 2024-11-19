<?php

namespace App\Livewire\Item;

use Livewire\Component;

class CommentsCounter extends Component
{
    public $item;

    public $isActive;

    protected $listeners = [
        'refreshCommentsCounter' => '$refresh',
    ];

    public function render()
    {
        return theme_view('livewire.item.comments-counter');
    }
}
