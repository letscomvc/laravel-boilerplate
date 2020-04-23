<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Styles -->
    <link href="{{ mix('css/app.css') }}" rel="stylesheet">
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
</head>

<body>
<div id="app">
    @include('layouts.flash-messages')
    <nav class="bg-gray-700 shadow mb-4 py-6">
        <div class="container mx-auto px-6 md:px-0">
            <div class="flex items-center justify-center">
                <div class="mr-6">
                    <a href="{{ url('/') }}" class="text-lg font-semibold text-gray-100 no-underline">
                        {{ config('app.name', 'Laravel') }}
                    </a>
                </div>
                <div class="flex-1 text-right">
                    @guest
                        <a class="no-underline hover:underline text-gray-100 text-sm p-3"
                           href="{{ route('login') }}">Login</a>
                        <a class="no-underline hover:underline text-gray-100 text-sm p-3"
                           href="{{ route('register') }}">Register</a>
                    @else
                        <span class="text-gray-100 text-sm pr-4">{{ Auth::user()->name }}</span>

                        <a class="no-underline hover:underline text-gray-100 text-sm pr-4"
                           href="{{route('users.index')}}">
                            Usuários
                        </a>

                        <a href="{{ route('logout') }}"
                           class="no-underline hover:underline text-gray-100 text-sm p-3"
                           onclick="event.preventDefault();
                                    document.getElementById('logout-form').submit();">{{ __('Logout') }}</a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">
                            {{ csrf_field() }}
                        </form>
                    @endguest
                </div>
            </div>
        </div>
    </nav>

    <vue-snotify></vue-snotify>

    <div class="container pt-3 px-10 mx-auto">
        @include('layouts.breadcrumb')

        @yield('content')
    </div>
</div>

<!-- Scripts -->
<script src="{{ mix('js/manifest.js') }}"></script>
<script src="{{ mix('js/vendor.js') }}"></script>
<script src="{{ mix('js/app.js') }}"></script>

</body>

</html>
