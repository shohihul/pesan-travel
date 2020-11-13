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
                        <h4>List Mobil</h4>
                    </div>
                    <div class="col-12 text-left">
                        <a href="{{route('admin.car.create')}}" class="btn btn-icon icon-left btn-primary"><i class="fas fa-plus"></i> <span>Tambah Mobil</span></a>
                    </div>
                    <br>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped table-md">
                            <tr>
                                <th>Merk - Tipe</th>
                                <th>Foto</th>
                                <th>Kapasitas</th>
                                <th>Action</th>
                            </tr>
                            @foreach ($car as $row)
                            <tr>
                                <td>{{$row->name}}</td>
                                <td>
                                    <div class="gallery gallery-md">
                                        <div class="gallery-item" data-image="{{ asset('assets/img/car/' . $row->photo) }}" data-title="{{$row->name}}"></div>
                                    </div>
                                </td>
                                <td>{{$row->capacity}}</td>
                                <td>
                                    <a class="btn btn-info" href="{{route('admin.car.edit', $row->id)}}">Ubah</a>
                                    <form action="{{route('admin.car.delete', $row->id)}}" method="POST" style="display: inline-block;">
                                        @csrf()
                                        @method('delete')
                                        <input type="submit" value="Hapus" class="btn btn-danger">
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                            </table>
                            <nav class="mt-4" aria-label="navigation">
                            {{$car->links()}}
                        </nav>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection