@extends('layouts.app', ['pageSlug' => 'car'])

@section('content')
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Mobil</h1>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Form Ubah Data Mobil</h4>
                    </div>
                    <div class="card-body">
                        <form method="post" action="{{route('admin.car.update', $car->id)}}" autocomplete="off" enctype="multipart/form-data">
                            @csrf
                            @method('put')
                            <div class="pl-lg-4">
                                <div class="form-group">
                                    <label>Merk - Tipe Mobil
                                            <span class="text-danger">*</span>
                                    </label>
                                    <input value="{{$car->name}}" name="name" type="text" placeholder="Misal : Toyota Hiace - Premio 2.8 M/T" class="form-control" required="" autofocus>
                                </div>
                                <div class="form-group">
                                    <label>Kapasitas Penumpang
                                            <span class="text-danger">*</span>
                                    </label>
                                    <input value="{{$car->capacity}}" name="capacity" type="number" placeholder="Kapasitas penumpang" class="form-control" required="">
                                </div>

                                <div class="text-right">
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

@section('script')
<script src="{{ asset('stisla/modules/upload-preview/assets/js/jquery.uploadPreview.min.js') }}"></script>
<script src="{{ asset('js/uploadPreview.js') }}"></script>
@endsection