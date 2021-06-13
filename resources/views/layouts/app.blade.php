<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>


    <meta data-n-head="ssr" data-hid="description" name="description" content="Hey there, I am Nahid Ferodus. This is a project demondtration demo. It is an online medical service, built using laravel-6, JQuery, Ajax, etc.">
    <meta name="description" content="Hey there, I am Nahid Ferodus. This is a project demondtration demo. It is an online medical service, built using laravel-6, JQuery, Ajax, etc.">
    <meta data-n-head="ssr" data-hid="og:description" name="og:description" property="og:description" content="Hey there, I am Nahid Ferodus. This is a project demondtration demo. It is an online medical service, built using laravel-6, JQuery, Ajax, etc.">
    <meta name="keywords" content="Nahid Ferdous, nahid, nahid_ferdous, nahid ferdous, Nahid, Ferdous, Nahidnfr, nfr, NFR, web, web development, designer, developer, bangladesh, art, design, laravel, vue js, vuejs, vue.js, php, laravel developer, project demo, project demonstration">
    <meta name="author" content="Nahid Ferdous">

    <meta data-n-head="ssr" data-hid="charset" charset="utf-8">
    <meta data-n-head="ssr" data-hid="mobile-web-app-capable" name="mobile-web-app-capable" content="yes">
    <meta data-n-head="ssr" data-hid="apple-mobile-web-app-title" name="apple-mobile-web-app-title" content="nahid ferdous">
    <meta data-n-head="ssr" data-hid="og:type" name="og:type" property="og:type" content="website">
    <meta data-n-head="ssr" data-hid="og:title" name="og:title" property="og:title" content="Nahid Ferdous! Project demonstration MedoCare.">
    <meta data-n-head="ssr" data-hid="og:site_name" name="og:site_name" property="og:site_name" content="Nahid Ferdous">


    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body>
<div id="app">
    <!-- Hope this works as a form of SEO -->
    <div class="HideText" style="height:0; width:0; opacity:0; overflow: hidden; color: transparent; background: transparent; position: fixed; z-index: -100; top:0; left:0;">
        <h1>Best developer in bangladesh.</h1>
        <h1>Nahid Ferdous</h1>
        <h2>Nahid Ferdous</h2>
        <h3>Nahid Ferdous</h3>
        <h4>Nahid Ferdous</h4>
        <h5>Nahid Ferdous</h5>
        <h6>Nahid Ferdous</h6>
        <h1>Nahid</h1>
        <h2>Nahid</h2>
        <h3>Nahid</h3>
        <h4>Nahid</h4>
        <h5>Nahid</h5>
        <h6>Nahid</h6>
        <h1>Ferdous</h1>
        <h2>Ferdous</h2>
        <h3>Ferdous</h3>
        <h4>Ferdous</h4>
        <h5>Ferdous</h5>
        <h6>Ferdous</h6>
        <a href="https://nahidferdous.com/">Nahid Ferdous</a>
        <a href="https://nahidferdous.com/">Nahid</a>
        <a href="https://nahidferdous.com/">Ferdous</a>
        <p>Nahid Ferdous</p>
        <div>Nahid Ferdous</div>
    </div>
    <!-- END -->
    <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
        <div class="container">
            <a class="navbar-brand" href="{{ url('/') }}">
                {{ config('app.name', 'Laravel') }}
            </a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
                    aria-controls="navbarSupportedContent" aria-expanded="false"
                    aria-label="{{ __('Toggle navigation') }}">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <!-- Left Side Of Navbar -->
                <ul class="navbar-nav mr-auto">

                </ul>

                <!-- Right Side Of Navbar -->
                <ul class="navbar-nav ml-auto">
                    <!-- Authentication Links -->
                    @guest
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                        </li>
                        @if (Route::has('register'))
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                            </li>
                        @endif
                    @else
                        <li class="nav-item dropdown">
                            <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button"
                               data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                {{ Auth::user()->name }} <span class="caret"></span>
                            </a>

                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item" href="{{ route('logout') }}"
                                   onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                    {{ __('Logout') }}
                                </a>

                                <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                      style="display: none;">
                                    @csrf
                                </form>
                            </div>
                        </li>
                    @endguest
                </ul>
            </div>
        </div>
    </nav>

    <main class="py-4">
        @yield('content')
    </main>
</div>
</body>
</html>
