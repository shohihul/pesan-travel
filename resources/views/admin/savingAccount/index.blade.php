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
                        <h4>List Rekening Pembayaran</h4>
                    </div>
                    <div class="col-12 text-left">
                        <a href="{{route('admin.saving_account.create')}}" class="btn btn-icon icon-left btn-primary"><i class="fas fa-plus"></i> <span>Tambah Rekening</span></a>
                    </div>
                    <br>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped table-md">
                            <tr>
                                <th>Logo</th>
                                <th>Bank</th>
                                <th>Nama Rekening</th>
                                <th>Nomor Rekening</th>
                                <th>Action</th>
                            </tr>
                            @foreach ($savingAccount as $row)
                            <tr>
                                <td>
                                    <div class="gallery">
                                        <div class="gallery-item" data-image="{{ asset('assets/img/bank/' . $row->logo) }}" data-title="{{$row->bank_account}}"></div>
                                    </div>
                                </td>
                                <td>{{$row->bank_account}}</td>
                                <td>{{$row->account_name}}</td>
                                <td>{{$row->account_number}}</td>
                                <td>
                                    <form action="{{route('admin.saving_account.destroy', $row->id)}}" method="post">
                                        @csrf
                                        @method('delete')
                                        <a class="btn btn-info" href="{{route('admin.saving_account.edit', $row->id)}}">Ubah</a>
                                        <input type="submit" value="Hapus" class="btn btn-danger">
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection