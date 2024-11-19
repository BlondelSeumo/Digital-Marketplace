@if (authUser())
    <button wire:click="addToFavorite"
        class="btn {{ authUser()->hasItemInFavorite($item->id) ? 'btn-favorite' : 'btn-outline-favorite' }} btn-md px-3">
        <i class=" {{ authUser()->hasItemInFavorite($item->id) ? 'fa-solid' : 'fa-regular' }} fa-heart"></i>
    </button>
@else
    <a href="{{ route('login') }}" class="btn btn-outline-favorite btn-md px-3">
        <i class="fa-regular fa-heart"></i>
    </a>
@endif
