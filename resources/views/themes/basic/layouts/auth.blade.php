<!DOCTYPE html>
<html lang="{{ getLocale() }}" dir="{{ getDirection() }}">

<head>
    @include('themes.basic.includes.head')
    <x-ad alias="head_code" />
</head>

<body {{ @$settings->announcement->status && !request()->hasCookie('announce_close') ? 'class=pt-0' : '' }}>
    <x-announcement />
    @include('themes.basic.includes.navbar', ['navbar_classes' => 'v2'])
    <section class="section">
        <div class="container container-custom">
            <div class="section-inner">
                <div class="section-body">
                    @yield('content')
                </div>
            </div>
        </div>
    </section>
    @include('themes.basic.includes.footer')
    @include('themes.basic.includes.config')
    @include('themes.basic.includes.scripts')
    @if ($errors->any())
        <script>
            @foreach ($errors->all() as $error)
                toastr.error('{{ $error }}')
            @endforeach
        </script>
    @elseif(session('status'))
        <script>
            toastr.success('{{ session('status') }}')
        </script>
    @elseif(session('resent'))
        <script>
            toastr.success('{{ translate('Link has been resend Successfully') }}')
        </script>
    @endif
</body>

</html>
