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

        <div class="card card-primary">
            <div class="card-header">
                <h4>Informasi Umum</h4>
                <div class="card-header-action">
                    <span class="badge badge-light" data-countdown="{{$data->start}}"></span> | 
                    @if ($data->route_ready == 0)
                        <a href="{{route('admin.doorToDoor_service.search_route', $data->id)}}" class="btn btn-primary {{(count($passenger) == 0) ? "disabled" : ""}}">
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
                    {{$data->car->name}}
                </div>
                <br>
                <div class="row align-items-center">
                    <strong class="col-sm-3 text-md-right">Kapasitas :</strong>
                    {{$data->car->capacity}} Penumpang
                </div>
                <br>
                <div class="row align-items-center">
                    <strong class="col-sm-3 text-md-right">Supir :</strong>
                    {{$data->driver->name}}
                </div>
                <br>
                <div class="row align-items-center">
                    <strong class="col-sm-3 text-md-right">Status :</strong>
                    <div class="col-sm-12 col-md-7">
                        <select class="form-control" id="service_status">
                            @foreach ($serviceStatus as $key => $status)
                                <option value={{$key}} {{($data->status == $key) ? 'selected' : ''}}>{{$status}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <br>
                <div class="row align-items-center">
                    <strong class="col-sm-3 text-md-right">Rute :</strong>
                    {{($data->route_ready == false) ? "Belum Tersedia" : "Tersedia"}}
                    &nbsp;&nbsp;&nbsp;
                    @if ($data->route_ready == true)<i class="fas fa-check text-success"></i>
                    @endif
                </div>
            </div>
        </div>

        <div class="card card-success">
            <div class="card-header">
                <h4>Penumpang</h4>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped table-md">
                    <tr>
                        <th>Akun</th>
                        <th>Jumlah Penumpang</th>
                        <th>Urutan Penjemputan</th>
                        <th>Urutan Pengantaran</th>
                        <th>Status Penumpang</th>
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
                        
                        <td>
                        @if ($row->status == "cencel")
                            <span class="text-secondary">{{@$passengerStatus[$row->status]}}</span>
                        @else
                            <span class="badge badge-light">{{@$passengerStatus[$row->status]}}</span>
                        @endif
                        </td>
                    </tr>
                    @endforeach
                    </table>
                </div>
            </div>
        </div>

        <div class="card card-info">
            <div class="card-header">
                <h4>Pemesan</h4>
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
                        <th>Status Pembayaran</th>
                        <th>Status Lokasi</th>
                        <th>Action</th>
                    </tr>
                    @foreach ($bookers as $row)
                    <tr>
                        <td>{{$row->user->name}}</td>
                        <td><i class="fas fa-user text-secondary"></i> {{$row->quantity}}</td>
                        <td>
                        @if ($row->invoice->status == "new")
                            <span class="text-secondary">{{@$invoiceStatus[$row->invoice->status]}}</span>
                        @elseif ($row->invoice->status == "on_process")
                            <span class="badge badge-warning">{{@$invoiceStatus[$row->invoice->status]}}</span>
                        @elseif ($row->invoice->status == "paid_off")
                            <span class="badge badge-success">{{@$invoiceStatus[$row->invoice->status]}}</span>
                        @else
                            <span>{{@$invoiceStatus[$row->invoice->status]}}</span>
                        @endif
                        </td>

                        <td>
                        @if ($row->location_point_status == "new")
                            <span class="badge badge-warning">{{@$locationStatus[$row->location_point_status]}}</span>
                        @elseif ($row->location_point_status == "approved")
                            <span class="badge badge-success">{{@$locationStatus[$row->location_point_status]}}</span>
                        @else
                            <span class="badge badge-light">{{@$locationStatus[$row->location_point_status]}}</span>
                        @endif
                        </td>

                        <td>
                            <a class="btn btn-info" href="{{route('admin.doorToDoor_order.show', $row->id)}}">Detail</a>
                            <form action="{{route('admin.doorToDoor_order.delete', $row->id)}}" method="POST" style="display: inline-block;">
                                @csrf()
                                @method('delete')
                                <input type="submit" value="Delete" class="btn btn-danger">
                            </form>
                        </td>
                        
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
<script src="{{ asset('stisla/modules/izitoast/js/iziToast.min.js') }}"></script>
<script src="http://maps.google.com/maps/api/js?&amp;key={{ env('GOOGLE_MAP_KEY') }}"></script>
<script src="{{ asset('stisla/modules/gmaps.js') }}"></script>
<meta name="csrf-token" content="{{ csrf_token() }}" />
<script>
    $('#service_status').change(function() {
        var serviceStatusDropdown = document.getElementById("service_status");
        var status = serviceStatusDropdown.options[serviceStatusDropdown.selectedIndex].value;
        var serviceId = {{$data->id}};
        console.log(status);
        $.ajax({
            type: 'POST',
            data: {_token: $('meta[name="csrf-token"]').attr('content'), status: status},
            dataType: 'json',
            url: '/ajax/doorToDoor_service/' + serviceId + '/update',
            success: function (data) { 
                iziToast.success({
                    title: 'Sukses',
                    message: data,
                    position: 'topRight'
                });
            }
        });
    });
</script>
@endsection

@section('style')
<link rel="stylesheet" href="{{ asset('stisla/modules/izitoast/css/iziToast.min.css') }}">
@endsection