<?php

namespace App\Livewire\Item;

use App\Models\Favorite;
use App\Traits\LivewireToastr;
use Livewire\Component;

class FavoriteButton extends Component
{
    use LivewireToastr;

    public $user;

    public $item;

    public function mount($item)
    {
        $this->user = authUser();
        $this->item = $item;
    }

    public function addToFavorite()
    {
        if ($this->user->isAdmin()) {
            return $this->toastr('error', translate('This action is not available for admins'));
        }

        if (!$this->user->hasItemInFavorite($this->item->id)) {
            $favorite = new Favorite();
            $favorite->user_id = $this->user->id;
            $favorite->item_id = $this->item->id;
            $favorite->save();
        } else {
            $favorite = $this->user->favorites->where('item_id', $this->item->id)->first();
            if ($favorite) {
                $favorite->delete();
            }
        }
    }

    public function render()
    {
        return theme_view('livewire.item.favorite-button');
    }
}
