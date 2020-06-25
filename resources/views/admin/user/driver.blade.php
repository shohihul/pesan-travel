@extends('layouts.app', ['pageSlug' => 'driver'])

@section('content')
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Supir</h1>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4>List Supir</h4>
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
                            @foreach ($driver as $row)
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
                                    <form action="{{ route('admin.user.delete', $row->id)}}" method="post">
                                        @csrf
                                        @method('delete')
                                        <a href="#" class="btn btn-info">Edit</a>
                                        <button type="submit"  class="btn btn-danger">
                                            Delete
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                            </table>
                            <nav class="mt-4" aria-label="navigation">
                                {{$driver->links()}}
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection