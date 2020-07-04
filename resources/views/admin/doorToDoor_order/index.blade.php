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
                                <th>Status Pembayaran</th>
                                <th>Rute Service</th>
                                <th>Status Lokasi</th>
                                <th>Action</th>
                            </tr>
                            @foreach ($orders as $row)
                            <tr>
                                <td>{{$row->id}}</td>
                                <td>{{$row->user->name}}</td>
                                <td class="text-warning mb-2">{{@$paymentStatus[$row->payment_status]}}</td>
                                <td class="text-primary mb-2">
                                    {{$row->doorToDoorService->origin->name}} - {{$row->doorToDoorService->destination->name}}
                                </td>
                                <td class="text-warning mb-2">{{@$locationStatus[$row->location_point_status]}}</td>
                                <td>
                                    <a class="btn btn-info" href="{{route('admin.doorToDoor_order.show', $row->id)}}">Detail</a>
                                    <button class="btn btn-danger">Hapus</button>
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