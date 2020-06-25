@extends('layouts.app')

@section('content')

<!-- Toolbar -->
<!-- <div class="toolbar toolbar--transparent toolbar--material">
    <div class="toolbar__left toolbar--material__left">
        <span class="toolbar-button toolbar-button--material">
        <i class="zmdi zmdi-menu"></i>
        </span>
    </div>
    <div class="toolbar__center toolbar--material__center">
        Pesan<b>Travel</b>
    </div>
    <div class="toolbar__right toolbar--material__right">
        <span class="toolbar-button toolbar-button--material">
        <i class="zmdi zmdi-notifications"></i>
        </span>
    </div>
</div> -->
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
    <p class="name">Alexander</p>

    <!-- <p class="name">Selamat Malam</p>
    <div>
        <a href="">Masuk</a> atau <a href="">Daftar</a>
    </div> -->
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
        <button class="menu-button">
            <div class="icon">
                <i class="fas fa-car"></i>
            </div>
            <div class="title"><b>Sewa Mobil</b></div>
        </button>

        <button class="menu-button">
            <div class="icon">
                <i class="fas fa-car"></i>
            </div>
            <div class="title"><b>Tour Wisata</b></div>
        </button>

        <button class="menu-button">
            <div class="icon">
                <i class="fas fa-car"></i>
            </div>
            <div class="title"><b>Private Trip</b></div>
        </button>

        <button class="menu-button">
            <div class="icon">
                <i class="fas fa-car"></i>
            </div>
            <div class="title"><b>Door to Door</b></div>
        </button>
    </div>
</div>
<!-- Menu -->

@endsection