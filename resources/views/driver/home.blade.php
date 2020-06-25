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
    <p class="name">Driver</p>

    <!-- <p class="name">Selamat Malam</p>
    <div>
        <a href="">Masuk</a> atau <a href="">Daftar</a>
    </div> -->
</div>
<!-- Salam -->

@endsection