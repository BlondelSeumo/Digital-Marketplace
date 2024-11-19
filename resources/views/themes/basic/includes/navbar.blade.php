<div class="nav-bar {{ $navbar_classes ?? '' }}">
    <div class="container container-custom">
        <div class="nav-bar-container">
            <a href="{{ route('home') }}" class="logo">
                <img src="{{ asset($themeSettings->general->logo_dark) }}" alt="{{ @$settings->general->site_name }}" />
            </a>
            <div class="nav-bar-menu">
                <div class="overlay"></div>
                <div class="nav-bar-menu-inner">
                    <div class="nav-bar-menu-header">
                        <a class="nav-bar-menu-close ms-auto">
                            <i class="fa fa-times"></i>
                        </a>
                    </div>
                    <div class="nav-bar-links">
                        @foreach ($navbarLinks as $navbarLink)
                            @if ($navbarLink->children->count() > 0)
                                <div class="drop-down" data-dropdown>
                                    <div class="drop-down-btn">
                                        <span class="me-2">{{ $navbarLink->name }}</span>
                                        <i class="bi bi-chevron-down ms-auto"></i>
                                    </div>
                                    <div class="drop-down-menu">
                                        @foreach ($navbarLink->children as $child)
                                            <a href="{{ $child->link }}"
                                                {{ $child->isExternal() ? 'target=_blank' : '' }}
                                                class="drop-down-item">
                                                <span>{{ $child->name }}</span>
                                            </a>
                                        @endforeach
                                    </div>
                                </div>
                            @else
                                <a href="{{ $navbarLink->link }}" {{ $navbarLink->isExternal() ? 'target=_blank' : '' }}
                                    class="link">
                                    <div class="link-title">
                                        <span>{{ $navbarLink->name }}</span>
                                    </div>
                                </a>
                            @endif
                        @endforeach
                        <a href="{{ route('cart.index') }}" class="link cart-btn w-auto d-none d-xxl-block me-2">
                            @if ($cartItemsCount)
                                <div class="cart-counter">{{ $cartItemsCount > 99 ? '+99' : $cartItemsCount }}</div>
                            @endif
                            <div class="link-title">
                                <i class="fa-solid fa-shopping-cart"></i>
                            </div>
                        </a>
                    </div>
                    <div class="nav-bar-buttons">
                        @if (licenseType(2) && @$settings->premium->status)
                            <a href="{{ route('premium.index') }}" class="link-btn">
                                <button class="btn btn-outline-premium px-4">
                                    <i class="fa-solid fa-crown me-1"></i>
                                    {{ translate('Premium') }}
                                </button>
                            </a>
                        @endif
                        @guest
                            <a href="{{ route('login') }}" class="link-btn">
                                <button class="btn btn-outline-primary px-4">{{ translate('Sign In') }}</button>
                            </a>
                            @if (@$settings->actions->registration)
                                <a href="{{ route('register') }}" class="link-btn">
                                    <button class="btn btn-primary px-4">{{ translate('Sign Up') }}</button>
                                </a>
                            @endif
                        @endguest
                    </div>
                </div>
            </div>
            <div class="nav-bar-actions">
                <a href="{{ route('cart.index') }}" class="link cart-btn w-auto d-block d-xxl-none mb-0 me-2">
                    @if ($cartItemsCount)
                        <div class="cart-counter">{{ $cartItemsCount > 99 ? '+99' : $cartItemsCount }}</div>
                    @endif
                    <div class="link-title">
                        <i class="fa-solid fa-shopping-cart"></i>
                    </div>
                </a>
                @auth
                    @include('themes.basic.partials.user-menu')
                @endauth
                <div class="nav-bar-menu-btn ms-3">
                    <i class="fa-solid fa-bars fa-lg"></i>
                </div>
            </div>
        </div>
    </div>
</div>
