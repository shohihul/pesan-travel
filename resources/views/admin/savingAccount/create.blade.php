@extends('layouts.app', ['pageSlug' => 'savingAccount'])

@section('content')
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Rekening Pembayaran</h1>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Form Tambah Rekening Pembayaran</h4>
                    </div>
                    <div class="card-body">
                        <form method="post" action="{{route('admin.saving_account.store')}}" autocomplete="off" enctype="multipart/form-data">
                            @csrf
                            <div class="pl-lg-4">
                                <div class="form-group">
                                    <label>Bank
                                            <span class="text-danger">*</span>
                                    </label>
                                    <input name="bank_account" type="text" placeholder="Misal : BRI" class="form-control" required="" autofocus>
                                </div>
                                <div class="form-group">
                                    <label>Nama Rekening
                                            <span class="text-danger">*</span>
                                    </label>
                                    <input name="account_name" type="text" placeholder="Nama Rekening" class="form-control" required="">
                                </div>

                                <div class="form-group">
                                    <label>Nomor Rekening
                                            <span class="text-danger">*</span>
                                    </label>
                                    <input name="account_number" type="number" placeholder="Nomor Rekening" class="form-control" required="">
                                </div>

                                <div class="form-group">
                                    <label>Logo Bank (.svg)
                                            <span class="text-danger">*</span>
                                    </label>
                                    <div id="image-preview" class="image-preview">
                                        <label for="image-upload" id="image-label">Choose File</label>
                                        <input class="form-control" type="file" name="logo" id="image-upload" required="">
                                    </div>
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