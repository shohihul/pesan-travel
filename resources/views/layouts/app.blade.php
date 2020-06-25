<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">

    @include('layouts.style')
    @yield('style')
</head>
<body>

    @auth()
        @if (Auth::user()->role_id == 1)
        <div id="app">
            <div class="main-wrapper main-wrapper-1">
            <div class="navbar-bg"></div>
                @include('admin.layouts.navbar')
                @include('admin.layouts.sidebar')
                @yield('content')
            </div>
        </div>

        @elseif (Auth::user()->role_id == 3)

            @yield('content')
            @include('layouts.tabbar')

        @endif
    @else

        @yield('content')

    @endauth
    
    @include('layouts.script')
    @yield('script')
    
</body>
</html>
