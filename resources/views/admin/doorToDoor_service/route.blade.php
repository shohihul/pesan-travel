@extends('layouts.app', ['pageSlug' => 'doorToDoor_service'])

@section('content')
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <div class="section-header-back">
                <a href="javascript:history.go(-1)" class="btn btn-icon"><i class="fas fa-arrow-left"></i></a>
            </div>
            <h1>Door To Door Service</h1>
        </div>

        <div class="card">
            <div class="card-header">
                <h4>Rute</h4>
            </div>
            <div class="card-body">
                <div class="section-title">Rute Penjemputan</div>
                <div id="pick-up-map" data-height="400"></div>
                <br>

                <div class="section-title">Rute Pengantaran</div>
                <div id="drop-off-map" data-height="400"></div>
            </div>
        </div>
    </section>
</div>
@endsection

@section('script')
<script src="{{ asset('js/jquery.countdown/jquery.countdown.min.js')}}"></script>
<script src="{{ asset('js/countdown.js') }}"></script>
<script src="http://maps.google.com/maps/api/js?&amp;key={{ env('GOOGLE_MAP_KEY') }}"></script>
<script src="{{ asset('stisla/modules/gmaps.js') }}"></script>
<script>
    var pickup_map = new GMaps({
            div: '#pick-up-map'
        });
        dropoff_map = new GMaps({
            div: '#drop-off-map'
        });

    var pickup_bounds = [];
    var dropoff_bounds = [];

    // add marker
    @foreach ($passenger as $row)
        pickup_bounds.push(new google.maps.LatLng( {{$row->pickup_point}} ));
        pickup_map.addMarker({
            position: new google.maps.LatLng( {{$row->pickup_point}} ),
            infoWindow: {
                content: '<h6>{{$row->user->name}}</h6><p>Urutan {{$row->pickup_sequence}}</p><p>{{$row->quantity}} penumpang</p>'
            }
        });
    @endforeach

    @foreach ($passenger as $row)
        dropoff_bounds.push(new google.maps.LatLng( {{$row->dropoff_point}} ));
        dropoff_map.addMarker({
            position: new google.maps.LatLng( {{$row->dropoff_point}} ),
            infoWindow: {
                content: '<h6>{{$row->user->name}}</h6><p>Urutan {{$row->dropoff_sequence}}</p><p>{{$row->quantity}} penumpang</p>'
            }
        });
    @endforeach

    pickup_map.fitLatLngBounds(pickup_bounds);
    dropoff_map.fitLatLngBounds(dropoff_bounds);

    @for ($i=0; $i < count($pickup_route); $i++)
        pickup_map.drawRoute({
            origin: [{{$pickup_route[$i][0]}}],
            destination: [{{$pickup_route[$i][1]}}],
            travelMode: 'driving',
            strokeColor: '#131540',
            strokeOpacity: 0.6,
            strokeWeight: 6
        });
    @endfor

    @for ($i=0; $i < count($dropoff_route); $i++)
        dropoff_map.drawRoute({
            origin: [{{$dropoff_route[$i][0]}}],
            destination: [{{$dropoff_route[$i][1]}}],
            travelMode: 'driving',
            strokeColor: '#131D55',
            strokeOpacity: 0.6,
            strokeWeight: 6
        });
    @endfor

    console.log('aaa');
    
</script>
@endsection