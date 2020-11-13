@extends('layouts.app', ['pageSlug' => 'customer'])

@section('content')
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Door To Door Order</h1>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4>List Pesanan Door to Door Service</h4>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped table-md">
                            <tr>
                                <th>Id</th>
                                <th>Nama</th>
                                <th>Rute Service</th>
                                <th>Status Pembayaran</th>
                                <th>Status Lokasi</th>
                                <th>Status Penumpang</th>
                                <th>Action</th>
                            </tr>
                            @foreach ($orders as $row)
                            <tr>
                                <td>{{$row->id}}</td>
                                <td>{{$row->user->name}}</td>
                                <td>
                                    <a href="{{route('admin.doorToDoor_service.show', $row->doorToDoorService->id)}}" class="badge badge-light">{{$row->doorToDoorService->origin->name}} - {{$row->doorToDoorService->destination->name}}</a>
                                </td>
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
                                @if ($row->status == "cencel")
                                    <span class="text-secondary">{{@$status[$row->status]}}</span>
                                @else
                                    <span class="badge badge-light">{{@$status[$row->status]}}</span>
                                @endif
                                </td>
                                <td>
                                    <a class="btn btn-info" href="{{route('admin.doorToDoor_order.show', $row->id)}}">Detail</a>
                                    <form action="{{route('admin.doorToDoor_order.delete', $row->id)}}" method="POST" style="display: inline-block;">
                                        @csrf()
                                        @method('delete')
                                        <input type="submit" value="Hapus" class="btn btn-danger">
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                            </table>
                            <nav class="mt-4" aria-label="navigation">
                                {{$orders->links()}}
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection