@extends('layouts.app', ['pageSlug' => 'home'])

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
</div>
<!-- Salam -->

<!-- Info -->

<!-- <div class="info">
    <div class="message">
        <i class="fas fa-exclamation-circle" style="color: red"></i>
        Tidak ada koneksi internet
    </div>
</div> -->

<div class="info">
    <div class="message">
        <i class="fas fa-clock" style="color: #13DB88"></i>
        Menunggu Penjemputan
    </div>
    <button class="button-secondary button-circle">
        <i class="fas fa-eye" style="margin: auto;"></i>
    </button>
</div>

<!-- Info -->

<!-- Menu -->
<div class="home-menu">
    <div class="menu">
        <a class="menu-button">
            <div class="icon">
                <i class="fas fa-car"></i>
            </div>
            <div class="title"><b>Sewa Mobil</b></div>
        </a>

        <a class="menu-button">
            <div class="icon">
                <i class="fas fa-umbrella-beach"></i>
            </div>
            <div class="title"><b>Tour Wisata</b></div>
        </a>

        <a class="menu-button">
            <div class="icon">
                <i class="fas fa-gifts"></i>
            </div>
            <div class="title"><b>Private Trip</b></div>
        </a>

        <a class="menu-button" href="{{route('customer.profile')}}">
            <div class="icon">
                <i class="fas fa-bus-alt"></i>
            </div>
            <div class="title"><b>Door to Door</b></div>
        </a>
    </div>
</div>
<!-- Menu -->

@endsection