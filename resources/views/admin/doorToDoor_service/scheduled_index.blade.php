@extends('layouts.app', ['pageSlug' => 'doorToDoor_service_scheduled'])

@section('content')
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Door To Door Service</h1>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Jadwal</h4>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped table-md">
                            <tr>
                                <th>Pemberangkatan</th>
                                <th>Tujuan</th>
                                <th>Jadwal</th>
                                <th>Tarif</th>
                                <th>Action</th>
                            </tr>
                            @foreach ($scheduled as $row)
                            <tr>
                                <td>{{$row->origin->name}}</td>
                                <td>{{$row->destination->name}}</td>
                                <td>{{date('d-M-Y H:i', strtotime($row->start))}}</td>
                                <td>Rp. {{number_format($row->price, 0, '.', '.')}}</td>
                                <td>
                                <a href="{{route('admin.doorToDoor_service.show', $row->id)}}" class="btn btn-primary">Kelola</a>
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