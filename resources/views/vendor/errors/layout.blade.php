<!DOCTYPE html>
<html lang="{{ getLocale() }}">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <title>@yield('code') - @yield('title')</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;1,100;1,200;1,300;1,400;1,500&display=swap">
    <link rel="stylesheet" href="{{ asset('vendor/libs/bootstrap/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/libs/fontawesome/fontawesome.min.css') }}">
</head>
<style> body { font-family: 'Poppins', 'Almarai', sans-serif; } .error-page { display: -webkit-box; display: -ms-flexbox; display: flex; -webkit-box-align: center; -ms-flex-align: center; align-items: center; -webkit-box-pack: center; -ms-flex-pack: center; justify-content: center; min-height: 90vh; padding: 3rem; background: #f3f5f9; } .error-page .error-card { text-align: center; } .error-page .error-card .error-code { margin: 0; font-weight: 600; font-size: 10rem; } .error-page .error-card .line { background-color: #5f5f5f; } .error-page .error-card .line { width: 150px; margin: 1rem auto; height: 3px; } .error-page .error-card .error-title { color: #585858; margin: 1rem 0; } @media (max-width:575.98px) { .error-page .error-card .error-code { font-size: 5rem; } .error-page .error-card .line { width: 100px; } } </style>
<body class="error-page">
    <div class="error-card">
        <h1 class="error-code">@yield('code')</h1>
        <div class="line"></div>
        <h1 class="error-title">@yield('title')</h1>
        <div class="row">
            <div class="col-lg-7 m-auto">
                <p>@yield('message')</p>
            </div>
        </div>
        <a href="{{ url('/') }}" class="btn btn-dark rounded-0 px-4 py-2"><i
                class="fa fa-home me-1"></i>{{ translate('Back to home') }}</a>
    </div>
    <script src="{{ asset('vendor/libs/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('vendor/libs/bootstrap/bootstrap.bundle.min.js') }}"></script>
</body>
</html>
