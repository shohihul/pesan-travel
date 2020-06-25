@extends('layouts.app', ['pageSlug' => 'profile'])

@section('content')

<!-- Toolbar -->
<div class="top">
    <div class="notification" align="right">
        <div>
            <i class="zmdi zmdi-notifications"></i>
        </div>
    </div>
</div>
<!-- Toolbar -->

<!-- Salam -->

<div class="greeting">
    <p class="time">Selamat Malam</p>
    <p class="name">
        {{ Auth::user()->name }}
    </p>

    <a class="dropdown-item" href="{{ route('logout') }}"
        onclick="event.preventDefault();
                        document.getElementById('logout-form').submit();">
        {{ __('Logout') }}
    </a>

    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
        @csrf
    </form>
</div>
<!-- Salam -->


@endsection