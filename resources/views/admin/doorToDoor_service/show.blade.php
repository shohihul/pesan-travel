@extends('layouts.app', ['pageSlug' => 'doorToDoor_service'])

@section('content')
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Door To Door Service</h1>
        </div>

        <div class="card card-primary">
            <div class="card-header">
                <h4>Informasi Umum</h4>
                <div class="card-header-action">
                    <span class="badge badge-light" data-countdown="{{$data->start}}"></span> | 
                    @if ($data->route_status == 0)
                        <a href="{{route('admin.doorToDoor_service.search_route', $data->id)}}" class="btn btn-primary">
                            <i class="fas fa-route"></i> Cari Rute Terbaik
                        </a>
                    @else
                        <a href="{{route('admin.doorToDoor_service.route', $data->id)}}" class="btn btn-primary">
                            <i class="fas fa-route"></i> Lihat Rute
                        </a>
                    @endif
                </div>
            </div>
            <div class="card-body">
                <div class="row align-items-center">
                    <strong class="col-sm-3 text-md-right">Kota Asal :</strong>
                    {{$data->origin->name}}
                </div>
                <br>
                <div class="row align-items-center">
                    <strong class="col-sm-3 text-md-right">Kota Tujuan :</strong>
                    {{$data->destination->name}}
                </div>
                <br>
                <div class="row align-items-center">
                    <strong class="col-sm-3 text-md-right">Pemberangkatan :</strong>
                    {{$data->start}}
                </div>
                <br>
                <div class="row align-items-center">
                    <strong class="col-sm-3 text-md-right">Tarif :</strong>
                    Rp. {{number_format($data->price, 0, '.', '.')}}
                </div>
                <br>
                <div class="row align-items-center">
                    <strong class="col-sm-3 text-md-right">Mobil :</strong>
                    {{$data->car->name}} - Kapasitas {{$data->car->capacity}} Penumpang
                </div>
                <br>
                <div class="row align-items-center">
                    <strong class="col-sm-3 text-md-right">Status :</strong>
                    Terjadwal
                </div>
                <br>
                <div class="row align-items-center">
                    <strong class="col-sm-3 text-md-right">Rute :</strong>
                    {{@$routeStatus[$data->route_status]}}
                    &nbsp;&nbsp;&nbsp;
                    @if ($data->route_status == 1)<i class="fas fa-check text-success"></i>
                    @endif
                </div>
            </div>
        </div>

        <div class="card card-info">
            <div class="card-header">
                <h4>Penumpang</h4>
                <div class="card-header-action">
                    <a href="{{route('admin.doorToDoor_order.create', $data->id)}}" class="btn btn-primary">
                        <i class="fas fa-plus"></i> Tambah Penumpang
                    </a>
                    
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped table-md">
                    <tr>
                        <th>Akun</th>
                        <th>Jumlah Penumpang</th>
                        <th>Urutan Penjemputan</th>
                        <th>Urutan Pengantaran</th>
                    </tr>
                    @foreach ($passenger as $row)
                    <tr>
                        <td>{{$row->user->name}}</td>
                        <td><i class="fas fa-user text-secondary"></i> {{$row->quantity}}</td>
                        @if ($row->pickup_sequence == null)
                            <td class="text-secondary">Belum Ada</td>
                        @else
                            <td>{{$row->pickup_sequence}}</td>
                        @endif

                        @if ($row->dropoff_sequence == null)
                            <td class="text-secondary">Belum Ada</td>
                        @else
                            <td>{{$row->dropoff_sequence}}</td>
                        @endif
                        
                    </tr>
                    @endforeach
                    </table>
                </div>
            </div>
        </div>
        
        <!-- <div class="card card-success">
            <div class="card-header">
                <h4>Rute</h4>
                <div class="card-header-action">
                    <a href="" class="btn btn-primary">
                        <i class="fas fa-plus"></i> Buat rute
                    </a>
                </div>
            </div>
            <div class="card-body">
                <div class="section-title">Titik Penjemputan</div>
                <div id="pick-up-map" data-height="400"></div>
                <br>

                <div class="section-title">Titik Pengantaran</div>
                <div id="drop-off-map" data-height="400"></div>
            </div>
        </div> -->
    </section>
</div>
@endsection

@section('script')
<script src="{{ asset('js/jquery.countdown/jquery.countdown.min.js')}}"></script>
<script src="{{ asset('js/countdown.js') }}"></script>
<script src="http://maps.google.com/maps/api/js?&amp;key={{ env('GOOGLE_MAP_KEY') }}"></script>
<script src="{{ asset('stisla/modules/gmaps.js') }}"></script>
@endsection