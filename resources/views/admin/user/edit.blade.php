@extends('layouts.app', ['pageSlug' => 'createAccount'])

@section('content')
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Ubah Data Akun</h1>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Form Ubah Data Akun</h4>
                    </div>
                    <div class="card-body">
                        <form method="post" action="{{route('admin.user.update', $user->id)}}" enctype="multipart/form-data">
                            @csrf
                            @method ('put')
                            <div class="pl-lg-4">
                                @if($user->photo != null)
                                    <div class="gallery gallery-md">
                                        <div class="gallery-item" data-image="{{ asset('assets/img/photo-profile/' . $user->photo) }}" data-title="{{$user->name}}"></div>
                                    </div>
                                @else
                                    <div class="gallery gallery-md">
                                        <div class="gallery-item" data-image="{{ asset('assets/img/photo-profile/blank.png') }}" data-title="Foto Kosong"></div>
                                    </div>
                                @endif

                                <div class="form-group">
                                    <label>Nama
                                            <span class="text-danger">*</span>
                                    </label>
                                    <div class="form-row">
                                        <div class="input-group col-md-8">
                                            <div class="input-group-prepend">
                                                <div class="input-group-text">
                                                    <i class="fas fa-user"></i>
                                                </div>
                                            </div>
                                            <input value="{{$user->name}}" name="name" type="text" placeholder="Nama" class="form-control" required="">
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label>E-mail
                                            <span class="text-danger">*</span>
                                    </label>
                                    <div class="form-row">
                                        <div class="input-group col-md-8">
                                            <div class="input-group-prepend">
                                                <div class="input-group-text">
                                                    <i class="fas fa-envelope"></i>
                                                </div>
                                            </div>
                                            <input value="{{$user->email}}" name="email" type="email" placeholder="Email" class="form-control" required="">
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label>Foto Profil</label>
                                    <div id="image-preview" class="image-preview">
                                        <label for="image-upload" id="image-label">Choose File</label>
                                        <input class="form-control" type="file" name="photo" id="image-upload">
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

@section('script')
<script src="{{ asset('stisla/modules/select2/dist/js/select2.min.js') }}"></script>
<script src="{{ asset('stisla/modules/upload-preview/assets/js/jquery.uploadPreview.min.js') }}"></script>
<script src="{{ asset('js/uploadPreview.js') }}"></script>
@endsection

@section('style')
<link rel="stylesheet" href="{{ asset('stisla/modules/select2/dist/css/select2.css') }}">
@endsection