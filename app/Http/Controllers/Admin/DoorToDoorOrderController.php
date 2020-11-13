<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\UserRepository;
use App\Repositories\DoorToDoorServiceRepository;
use App\Repositories\DoorToDoorOrderRepository;
use App\Repositories\InvoiceRepository;

use App\Http\Requests\DoorToDoorOrderStoreRequest;
use App\Http\Requests\DoorToDoorOrderUpdateRequest;

use App\Models\DoorToDoorOrder;

class DoorToDoorOrderController extends Controller
{
    private $userRepository;
    private $doorToDoorServiceRepository;
    private $doorToDoorOrderRepository;
    private $invoiceRepository;

    public function __construct (UserRepository $userRepository, DoorToDoorServiceRepository $doorToDoorServiceRepository, DoorToDoorOrderRepository $doorToDoorOrderRepository, InvoiceRepository $invoiceRepository)
    {
        $this->middleware('roles:admin');

        $this->userRepository = $userRepository;
        $this->doorToDoorServiceRepository = $doorToDoorServiceRepository;
        $this->doorToDoorOrderRepository = $doorToDoorOrderRepository;
        $this->invoiceRepository = $invoiceRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $per_page = 10;
        $invoiceStatus = $this->invoiceRepository->getInvoiceStatus();
        $locationStatus = $this->doorToDoorOrderRepository->getLocationStatus();
        $status = $this->doorToDoorOrderRepository->getStatus();
        $orders = $this->doorToDoorOrderRepository->get_paginate($per_page);

        return view('admin.doorToDoor_order.index',
            compact(
                'orders',
                'invoiceStatus',
                'locationStatus',
                'status'
            )
        );
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id)
    {
        $customers = $this->userRepository->get_customer();
        $service = $this->doorToDoorServiceRepository->find($id);

        return view('admin.doorToDoor_order.create',
            compact(
                'customers',
                'service'
            )
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(DoorToDoorOrderStoreRequest $request)
    {
        $doorToDoorService_id = $request->get('door_to_door_service_id');
        $doorToDoorService = $this->doorToDoorServiceRepository->find($doorToDoorService_id);

        $order = $this->doorToDoorOrderRepository->store($request);
        $this->doorToDoorServiceRepository->route_ready_false($doorToDoorService);

        $request->request->add([
            'due_date' => date('Y-m-d H:i:s', strtotime('-1 day', strtotime($doorToDoorService->start))),
            'service' => 'Antar Kota',
            'door_to_door_order_id' => $order->id,
        ]);

        $invoice = $this->invoiceRepository->store($request);
        

        return redirect(route('admin.doorToDoor_service.show', $doorToDoorService_id));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(DoorToDoorOrder $doorToDoorOrder)
    {
        $invoiceStatus = $this->invoiceRepository->getInvoiceStatus();
        $locationStatus = $this->doorToDoorOrderRepository->getLocationStatus();
        $status = $this->doorToDoorOrderRepository->getStatus();
        $doorToDoorService_id = $doorToDoorOrder->door_to_door_service_id;
        $service = $this->doorToDoorServiceRepository->find($doorToDoorService_id);
        return view('admin.doorToDoor_order.show',
            compact(
                'doorToDoorOrder',
                'service',
                'invoiceStatus',
                'locationStatus',
                'status'
            )
        );
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function location_edit(DoorToDoorOrder $doorToDoorOrder)
    {
        $doorToDoorService_id = $doorToDoorOrder->door_to_door_service_id;
        $service = $this->doorToDoorServiceRepository->find($doorToDoorService_id);
        return view('admin.doorToDoor_order.location_edit',
            compact(
                'doorToDoorOrder',
                'service'
            )
        );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(DoorToDoorOrderUpdateRequest $request, DoorToDoorOrder $doorToDoorOrder)
    {
        $this->doorToDoorOrderRepository->update($request, $doorToDoorOrder);

        return redirect(route('admin.doorToDoor_order.show', $doorToDoorOrder->id));
    }

    public function ajax_update(Request $request, DoorToDoorOrder $doorToDoorOrder)
    {
        $this->doorToDoorOrderRepository->update($request, $doorToDoorOrder);
        $response = "Status lokasi berhasil diperbaharui";

        return response()->json($response);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete(DoorToDoorOrder $doorToDoorOrder)
    {
        $this->doorToDoorOrderRepository->delete($doorToDoorOrder);

        return redirect(route('admin.doorToDoor_order.index'));
    }
}
