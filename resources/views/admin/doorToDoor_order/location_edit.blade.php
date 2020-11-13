@extends('layouts.app', ['pageSlug' => ''])

@section('content')
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Door To Door Order</h1>
        </div>

        <div class="section-body">
            <h2 class="section-title">{{$service->origin->name}} - {{$service->destination->name}}</h2>
            <p class="section-lead">
                {{date('d-M-Y | H:i', strtotime($service->start))}}
            </p>

            <div class="card">
                <div class="card-header">
                    <h4>Ubah Lokasi Penjemputan & Pengantaran Penumpang</h4>
                </div>
                <div class="card-body">
                    <form method="post" action="{{route('admin.doorToDoor_order.update', $doorToDoorOrder->id)}}" autocomplete="off" enctype="multipart/form-data">
                        @csrf
                        @method ('put')
                        <div class="pl-lg-4">
                            <input type="text" name="pickup_point" id="input-pickUp-point" value="{{$doorToDoorOrder->pickup_point}}" hidden>
                            <input type="text" name="dropoff_point" id="input-dropOff-point" value="{{$doorToDoorOrder->dropoff_point}}" hidden>

                            <div class="form-group">
                                <label>Akun Penumpang</label>
                                <input type="text" class="form-control-plaintext" readonly="" value="{{$doorToDoorOrder->user->name}}">
                            </div>

                            <div class="form-group">
                                <label>Jumlah Penumpang</label>
                                <input type="text" class="form-control-plaintext" readonly="" value="{{$doorToDoorOrder->quantity}} Penumpang">
                            </div>

                            <div class="form-group">
                                <label>Titik Penjemputan
                                        <span class="text-danger">*</span>
                                </label>
                                <div id="map-pickUp-point" data-height="400"></div>
                            </div>

                            <div class="form-group">
                                <label>Titik Pengantaran
                                        <span class="text-danger">*</span>
                                </label>
                                <div id="map-dropOff-point" data-height="400"></div>
                            </div>

                            <div class="text-right">
                                <button type="submit" class="btn btn-icon icon-left btn-success">
                                    <i class="fas fa-check"></i> Simpan
                                </button>
                                <a href="route('admin.doorToDoor_order.update', $doorToDoorOrder->id)" class="btn btn-outline-secondary">Batal</a>
                            </div>
                        </div>
                    </form>
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
    var input_quantity = $("#input_quantity"),
        input_amount = $("#input_amount"),
        input_pickUp_point = $("#input-pickUp-point"),
        input_dropOff_point = $("#input-dropOff-point"),
        pickUp_point = new GMaps({
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

    // when the map is clicked
    pickUp_point.addListener("click", function(e) {
        var lat = e.latLng.lat(), 
            lng = e.latLng.lng();

        // move the marker position
        marker_pickUp_point.setPosition({
            lat: lat,
            lng: lng,
        });
        marker_pickUp_point.setVisible(true);

        var lat_pickUp_point = marker_pickUp_point.getPosition().lat(),
            lng_pickUp_point = marker_pickUp_point.getPosition().lng();

        input_pickUp_point.val(lat_pickUp_point + "," + lng_pickUp_point);
    });

    dropOff_point.addListener("click", function(e) {
        var lat = e.latLng.lat(), 
            lng = e.latLng.lng();

        // move the marker position
        marker_dropOff_point.setPosition({
            lat: lat,
            lng: lng,
        });
        marker_dropOff_point.setVisible(true);

        var lat_dropOff_point = marker_dropOff_point.getPosition().lat(),
            lng_dropOff_point = marker_dropOff_point.getPosition().lng();

        input_dropOff_point.val(lat_dropOff_point + "," + lng_dropOff_point);
    });

    $("#input_quantity").change(function (){
        var quantity = parseInt(input_quantity.val(), 10),
            price = {{json_encode($service->price)}};

        $("#input_amount").val(quantity * price)
    });
</script>
@endsection

@section('style')
<link rel="stylesheet" href="{{ asset('stisla/modules/select2/dist/css/select2.css') }}">
@endsection