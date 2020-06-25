@extends('layouts.app', ['pageSlug' => 'doorToDoor_service_create'])

@section('content')
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Door To Door</h1>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Form Tambah Jadwal</h4>
                    </div>
                    <div class="card-body">
                        <form method="post" action="{{route('admin.doorToDoor_service.store')}}" autocomplete="off">
                            @csrf
                            <div class="pl-lg-4">
                                <div class="form-group">
                                    <label>Kota Pemberangkatan<span class="text-danger">*</span></label>
                                    <div class="form-row">
                                        <div class="input-group col-md-4">
                                            <select class="form-control select2" id="province_origin">
                                                <option disable>Provinsi</option>
                                                @foreach ($province as $provinsi)
                                                <option value="{{$provinsi->id}}">{{$provinsi->name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="input-group col-md-4">
                                            <select class="form-control select2" id="regencie_origin" required="" name="origin_id">
                                                <option disable>Kota/Kabupaten</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label>Kota Tujuan<span class="text-danger">*</span></label>
                                    <div class="form-row">
                                        <div class="input-group col-md-4">
                                            <select class="form-control select2" id="province_destination">
                                                <option disable>Provinsi</option>
                                                @foreach ($province as $provinsi)
                                                <option value="{{$provinsi->id}}">{{$provinsi->name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="input-group col-md-4">
                                            <select class="form-control select2" id="regencie_destination" required="" name="destination_id">
                                                <option disable>Kota/Kabupaten</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label>Tanggal & Jam Pemberangkatan
                                            <span class="text-danger">*</span>
                                    </label>
                                    <div class="form-row">
                                        <div class="input-group col-md-8">
                                            <div class="input-group-prepend">
                                                <div class="input-group-text">
                                                    <i class="fad fa-calendar"></i>
                                                </div>
                                            </div>
                                            <input type="text" class="form-control datetimepicker" name="start">
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label>Mobil<span class="text-danger">*</span></label>
                                    <div class="form-row">
                                        <div class="input-group col-md-8">
                                            <div class="input-group-prepend">
                                                <div class="input-group-text">
                                                    <i class="fas fa-car"></i>
                                                </div>
                                            </div>
                                            <select class="form-control select2" required="" name="car_id">
                                                @foreach ($cars as $car)
                                                <option value="{{$car->id}}">{{$car->name}} - {{$car->capacity}} Penumpang</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label>Supir<span class="text-danger">*</span></label>
                                    <div class="form-row">
                                        <div class="input-group col-md-8">
                                            <div class="input-group-prepend">
                                                <div class="input-group-text">
                                                    <i class="fas fa-steering-wheel"></i>
                                                </div>
                                            </div>
                                            <select class="form-control select2" required="" name="driver_id">
                                                @foreach ($drivers as $driver)
                                                <option value="{{$driver->id}}">{{$driver->name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label>Tarif<span class="text-danger">*</span></label>
                                    <div class="form-row">
                                        <div class="input-group col-md-8">
                                            <div class="input-group-prepend">
                                                <div class="input-group-text">
                                                    <b>Rp.</b>
                                                </div>
                                            </div>
                                            <input name="price" type="numeric" placeholder="Tarif per orang" class="form-control currency" required="">
                                        </div>
                                    </div>
                                </div>

                                <div class="text-left">
                                    <button type="submit" class="btn btn-icon icon-left btn-success">
                                        <i class="fas fa-check"></i> Simpan
                                    </button>
                                    <a href="javascript:history.go(-1)" class="btn btn-outline-secondary">Batal</a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection

@section ('script')
<script src="{{ asset('stisla/modules/select2/dist/js/select2.min.js') }}"></script>
<script src="{{ asset('stisla/modules/cleave-js/dist/cleave.min.js') }}"></script>
<script src="{{ asset('stisla/modules/bootstrap-timepicker/js/bootstrap-timepicker.min.js') }}"></script>
<script src="{{ asset('stisla/modules/bootstrap-daterangepicker/daterangepicker.js') }}"></script>
<script type="text/javascript">

    $("#province_origin").change(function(){
        $.ajax({
            url: "{{ route('getRegencieByProvince') }}?province_id=" + $(this).val(),
            method: 'GET',
            success: function(regencie) {
                $('#regencie_origin').html(regencie.html);
            }
        });
    });

    $("#province_destination").change(function(){
        $.ajax({
            url: "{{ route('getRegencieByProvince') }}?province_id=" + $(this).val(),
            method: 'GET',
            success: function(regencie) {
                $('#regencie_destination').html(regencie.html);
            }
        });
    });
    
</script>
@endsection

@section('style')
<link rel="stylesheet" href="{{ asset('stisla/modules/select2/dist/css/select2.css') }}">
<link rel="stylesheet" href="{{ asset('stisla/modules/bootstrap-daterangepicker/daterangepicker.css') }}">
<link rel="stylesheet" href="{{ asset('stisla/modules/bootstrap-timepicker/css/bootstrap-timepicker.css') }}">
@endsection