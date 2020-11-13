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
                        <div class="col-sm-12 col-md-7">
                            {{$doorToDoorOrder->user->name}}
                        </div>
                    </div>
                    <br>
                    <div class="row align-items-center">
                        <strong class="col-sm-3 text-md-right">Jumlah Penumpang : </strong>
                        <div class="col-sm-12 col-md-7">
                            {{$doorToDoorOrder->quantity}} orang
                        </div>
                    </div>
                    <br>
                    <div class="row align-items-center">
                        <strong class="col-sm-3 text-md-right">Status Penumpang : </strong>
                        <div class="col-sm-12 col-md-7">
                            <select class="form-control" id="passenger_status">
                                @foreach ($status as $key => $status)
                                    <option value={{$key}} {{($doorToDoorOrder->status == $key) ? 'selected' : ''}}>{{$status}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <br>
                    <div class="row align-items-center">
                        <strong class="col-sm-3 text-md-right">Status Pembayaran : </strong>
                        <div class="col-sm-12 col-md-7">
                            <select class="form-control" id="invoice_status">
                                @foreach ($invoiceStatus as $key => $status)
                                    <option value={{$key}} {{($doorToDoorOrder->invoice->status == $key) ? 'selected' : ''}}>{{$status}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <br>
                    <div class="row align-items-center">
                        <strong class="col-sm-3 text-md-right">Status Lokasi : </strong>
                        <div class="col-sm-12 col-md-7">
                            <select class="form-control" id="location_status">
                                @foreach ($locationStatus as $key => $status)
                                    <option value={{$key}} {{($doorToDoorOrder->location_point_status == $key) ? 'selected' : ''}}>{{$status}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <br>
                    <div class="row align-items-center">
                        <strong class="col-sm-3 text-md-right">Pesan Admin : </strong>
                        <div class="col-sm-12 col-md-7">
                            <textarea class="form-control" id="admin_note">{{$doorToDoorOrder->admin_note}}</textarea>
                        </div>
                        <button class="btn btn-primary" id="send_button">Kirim</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="card card-info">
            <div class="card-header">
                <h4>Lokasi</h4>
                @if ($doorToDoorOrder->location_point_status == 'new' or $doorToDoorOrder->location_point_status == 'rejected')
                    <div class="card-header-action">
                        <a href="{{route('admin.doorToDoor_order.location_edit', $doorToDoorOrder->id)}}" class="btn btn-primary"><i class="fas fa-map-marker-alt"></i> Ubah Status Lokasi</a>
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
<script src="{{ asset('stisla/modules/izitoast/js/iziToast.min.js') }}"></script>
<script src="http://maps.google.com/maps/api/js?&amp;key={{ env('GOOGLE_MAP_KEY') }}"></script>
<script src="{{ asset('stisla/modules/gmaps.js') }}"></script>
<meta name="csrf-token" content="{{ csrf_token() }}" />
<script>

    $('#invoice_status').change(function() {
        var invoiceStatusDropdown = document.getElementById("invoice_status");
        var status = invoiceStatusDropdown.options[invoiceStatusDropdown.selectedIndex].value;
        var invoiceId = {{$doorToDoorOrder->invoice->id}};
        $.ajax({
            type: 'POST',
            data: {_token: $('meta[name="csrf-token"]').attr('content'), status: status},
            dataType: 'json',
            url: '/ajax/invoice/' + invoiceId + '/update',
            success: function (data) { 
                iziToast.success({
                    title: 'Sukses',
                    message: data,
                    position: 'topRight'
                });
            }
        });
    });

    $('#location_status').change(function() {
        var locationStatusDropdown = document.getElementById("location_status");
        var status = locationStatusDropdown.options[locationStatusDropdown.selectedIndex].value;
        var orderId = {{$doorToDoorOrder->id}};
        $.ajax({
            type: 'POST',
            data: {_token: $('meta[name="csrf-token"]').attr('content'), location_point_status: status},
            dataType: 'json',
            url: '/ajax/doorToDoor_order/' + orderId + '/update',
            success: function (data) { 
                iziToast.success({
                    title: 'Sukses',
                    message: data,
                    position: 'topRight'
                });
            }
        });
    });

    $('#passenger_status').change(function() {
        var passengerStatusDropdown = document.getElementById("passenger_status");
        var status = passengerStatusDropdown.options[passengerStatusDropdown.selectedIndex].value;
        var orderId = {{$doorToDoorOrder->id}};
        $.ajax({
            type: 'POST',
            data: {_token: $('meta[name="csrf-token"]').attr('content'), status: status},
            dataType: 'json',
            url: '/ajax/doorToDoor_order/' + orderId + '/update',
            success: function (data) { 
                iziToast.success({
                    title: 'Sukses',
                    message: data,
                    position: 'topRight'
                });
            }
        });
    });

    $('#send_button').click(function() {
       var admin_note = document.getElementById("admin_note").value;
       var orderId = {{$doorToDoorOrder->id}};
       $.ajax({
            type: 'POST',
            data: {_token: $('meta[name="csrf-token"]').attr('content'), admin_note: admin_note},
            dataType: 'json',
            url: '/ajax/doorToDoor_order/' + orderId + '/update',
            success: function (data) { 
                iziToast.success({
                    title: 'Sukses',
                    message: data,
                    position: 'topRight'
                });
            }
        });
    });

    var pickUp_point = new GMaps({
            div: '#map-pickUp-point',
            zoom: 12
        });
        dropOff_point = new GMaps({
            div: '#map-dropOff-point',
            zoom: 12
        });
        marker_pickUp_point = pickUp_point.addMarker({
            position: new google.maps.LatLng( {{$doorToDoorOrder->pickup_point}} ),
            title: 'Titik Penjemputan'
        });
        marker_dropOff_point = dropOff_point.addMarker({
            position: new google.maps.LatLng( {{$doorToDoorOrder->dropoff_point}} ),
            title: 'Titik Pengantaran'
        });
    
    pickUp_point.setCenter({{$doorToDoorOrder->pickup_point}});
    dropOff_point.setCenter({{$doorToDoorOrder->dropoff_point}});
</script>
@endsection

@section('style')
<link rel="stylesheet" href="{{ asset('stisla/modules/select2/dist/css/select2.css') }}">
<link rel="stylesheet" href="{{ asset('stisla/modules/izitoast/css/iziToast.min.css') }}">
@endsection