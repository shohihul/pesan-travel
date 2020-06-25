@extends('layouts.app', ['pageSlug' => 'doorToDoor_service'])

@section('content')
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Door To Door Service</h1>
        </div>
        <div class="card card-success">
            <div class="card-header">
                <h4>Rute</h4>
            </div>
            <div class="card-body">
                <div class="section-title">Titik Penjemputan</div>
                <div id="pick-up-map" data-height="400"></div>
                <br>
                <form action="{{route('admin.doorToDoor_service.search_route')}}" method="post">
                    @csrf
                    <input type="text" id="point" name="point">
                    <button type="submit" class="btn btn btn-primary">Cari Rute</button>
                </form>
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
    var pick_up_map = new GMaps({
            div: '#pick-up-map',
            zoom: 12
        });
        point = [];
        arrDistance = [],

    @foreach ($passenger as $row)
        point.push([{{$row->pick_up_point}}]);
    @endforeach

    $('#point').val(point);
    
    GMaps.geocode({
        address: '{{$data->origin->name}}',
        callback: function(results, status) {
            if (status == 'OK') {
                var latlng = results[0].geometry.location;
                pick_up_map.setCenter(latlng.lat(), latlng.lng());
            }
        }
    });

    // add marker
    @foreach ($passenger as $row)
        pick_up_map.addMarker({
            position: new google.maps.LatLng( {{$row->pick_up_point}} ),
            infoWindow: {
                content: '<h6>{{$row->user->name}}</h6><p>{{$row->quantity}} penumpang</p'
            }
        });
    @endforeach
</script>
@endsection