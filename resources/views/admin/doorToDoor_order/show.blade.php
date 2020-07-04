@extends('layouts.app', ['pageSlug' => ''])

@section('content')
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <div class="section-header-back">
                <a href="javascript:history.go(-1)" class="btn btn-icon"><i class="fas fa-arrow-left"></i></a>
            </div>
            <h1>Door To Door Order</h1>
        </div>

        <div class="card card-primary">
            <div class="card-header">
                <h4>Detail Data Pesanan</h4>
            </div>
            <div class="card-body">
                <div class="pl-lg-4">
                    <div class="row align-items-center">
                        <strong class="col-sm-3 text-md-right">Akun Penumpang : </strong>
                        {{$doorToDoorOrder->user->name}}
                    </div>
                    <br>
                    <div class="row align-items-center">
                        <strong class="col-sm-3 text-md-right">Jumlah Penumpang : </strong>
                        {{$doorToDoorOrder->quantity}} orang
                    </div>
                    <br>
                    <div class="row align-items-center">
                        <strong class="col-sm-3 text-md-right">Status Pembayaran : </strong>
                        {{@$paymentStatus[$doorToDoorOrder->payment_status]}}
                    </div>
                    <br>
                    <div class="row align-items-center">
                        <strong class="col-sm-3 text-md-right">Status Lokasi : </strong>
                        {{@$locationStatus[$doorToDoorOrder->location_point_status]}}
                    </div>
                    <br>
                    <div class="text-right">
                        @if ($doorToDoorOrder->payment_status == 'new')
                            <a href="javascript:history.go(-1)" class="btn btn-primary"><i class="fas fa-file-invoice-dollar"></i> Konfirmasi Pembayaran</a>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <div class="card card-info">
            <div class="card-header">
                <h4>Lokasi</h4>
                @if ($doorToDoorOrder->location_point_status == 'new' or $doorToDoorOrder->location_point_status == 'rejected')
                    <div class="card-header-action">
                        <a href="javascript:history.go(-1)" class="btn btn-primary"><i class="fas fa-map-marker-alt"></i> Ubah Status Lokasi</a>
                    </div>
                @endif
            </div>

            <div class="card-body">
                <div class="form-group">
                    <label>Titik Penjemputan</label>
                    <div id="map-pickUp-point" data-height="400"></div>
                </div>

                <div class="form-group">
                    <label>Titik Pengantaran
                            <span class="text-danger">*</span>
                    </label>
                    <div id="map-dropOff-point" data-height="400"></div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection

@section('script')
<script src="{{ asset('stisla/modules/select2/dist/js/select2.min.js') }}"></script>
<script src="http://maps.google.com/maps/api/js?&amp;key={{ env('GOOGLE_MAP_KEY') }}"></script>
<script src="{{ asset('stisla/modules/gmaps.js') }}"></script>
<script>
    var pickUp_point = new GMaps({
            div: '#map-pickUp-point',
            zoom: 12
        });
        dropOff_point = new GMaps({
            div: '#map-dropOff-point',
            zoom: 12
        });
        marker_pickUp_point = pickUp_point.addMarker({
            position: new google.maps.LatLng( {{$doorToDoorOrder->pick_up_point}} ),
            title: 'Titik Penjemputan'
        });
        marker_dropOff_point = dropOff_point.addMarker({
            position: new google.maps.LatLng( {{$doorToDoorOrder->drop_off_point}} ),
            title: 'Titik Pengantaran'
        });
    
    pickUp_point.setCenter({{$doorToDoorOrder->pick_up_point}});
    dropOff_point.setCenter({{$doorToDoorOrder->drop_off_point}});
</script>
@endsection

@section('style')
<link rel="stylesheet" href="{{ asset('stisla/modules/select2/dist/css/select2.css') }}">
@endsection