<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Styles -->
    <link href="{{ mix('assets/css/app.css') }}" rel="stylesheet">
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet"> @yield('header')
</head>

<body>
    <div id="app">
        @include('layouts.flash-messages')
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
                {{ config('app.name', 'Laravel') }}
            </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

                <div class="collapse navbar-collapse justify-content-end" id="navbarSupportedContent">
                    <ul class="navbar-nav">
                        @if (Auth::guest())
                        <li class="nav-item"><a href="{{ route('login') }}" class="nav-link">Login</a></li>
                        <li class="nav-item"><a href="{{ route('register') }}" class="nav-link">Register</a></li>
                        @else
                        <li class="nav-item">
                            <a class="nav-link" href="{{route('users.index')}}">Usuários</a>
                        </li>
                        <li class="nav-item dropdown">
                            <a href="#" class="nav-link dropdown-toggle" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                {{ Auth::user()->name }}
                            </a>
                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownMenuLink">
                                <a href="{{ route('logout') }}" class="dropdown-item" onclick="event.preventDefault();document.getElementById('logout-form').submit();">
                                    Logout
                                </a>

                                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                    @csrf
                                </form>
                            </div>
                        </li>
                        @endif
                    </ul>
                </div>

            </div>
        </nav>

        <vue-snotify></vue-snotify>

        @yield('custom-template')

        <div class="container pt-3">
            @include('layouts.breadcrumb')
            @yield('content')
        </div>
    </div>

    <!-- Scripts -->
    <script src="{{ mix('assets/js/manifest.js') }}"></script>
    <script src="{{ mix('assets/js/vendor.js') }}"></script>
    <script src="{{ mix('assets/js/app.js') }}"></script>

    @yield('footer')
</body>

</html>
