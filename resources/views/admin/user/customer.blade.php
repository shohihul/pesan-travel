@extends('layouts.app', ['pageSlug' => 'customer'])

@section('content')
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Pelanggan</h1>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4>List Pelanggan</h4>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped table-md">
                            <tr>
                                <th>Id</th>
                                <th>Nama</th>
                                <th>Email</th>
                                <th>Foto</th>
                                <th>Action</th>
                            </tr>
                            @foreach ($customer as $row)
                            <tr>
                                <td>{{$row->id}}</td>
                                <td>{{$row->name}}</td>
                                <td>{{$row->email}}</td>
                                <td>
                                    <div class="gallery gallery-md">
                                        <div class="gallery-item" data-image="{{ asset('assets/img/photo-profile/' . $row->photo) }}" data-title="{{$row->name}}"></div>
                                    </div>
                                </td>
                                <td>
                                    <a class="btn btn-info" href="{{route('admin.user.edit', $row->id)}}">Ubah</a>
                                    <form action="{{route('admin.user.delete', $row->id)}}" method="POST" style="display: inline-block;">
                                        @csrf()
                                        @method('delete')
                                        <input type="submit" value="Hapus" class="btn btn-danger">
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                            </table>
                            <nav class="mt-4" aria-label="navigation">
                                {{$customer->links()}}
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection