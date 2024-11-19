<!DOCTYPE html>
<html lang="{{ getLocale() }}" dir="{{ getDirection() }}">

<head>
    @include('themes.basic.includes.head')
    <x-ad alias="head_code" />
</head>

<body {{ @$settings->announcement->status && !request()->hasCookie('announce_close') ? 'class=pt-0' : '' }}>
    <x-announcement />
    @include('themes.basic.includes.navbar')
    @yield('content')
    @include('themes.basic.includes.footer')
    @include('themes.basic.includes.config')
    @include('themes.basic.includes.scripts')
</body>

</html>
