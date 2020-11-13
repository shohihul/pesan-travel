<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Repositories\UserRepository;
use App\Repositories\DoorToDoorServiceRepository;
use App\Repositories\DoorToDoorOrderRepository;
use App\Repositories\InvoiceRepository;
use App\Http\Resources\DoorToDoorOrder\DoorToDoorOrderListCollection;
use App\Http\Resources\DoorToDoorOrder\DoorToDoorOrderItem;


class DoorToDoorOrderController extends Controller
{
    public $successStatus = 200;
    
    private $userRepository;
    private $doorToDoorServiceRepository;
    private $doorToDoorOrderRepository;
    private $invoiceRepository;

    public function __construct (UserRepository $userRepository, DoorToDoorServiceRepository $doorToDoorServiceRepository, DoorToDoorOrderRepository $doorToDoorOrderRepository, InvoiceRepository $invoiceRepository)
    {
        $this->userRepository = $userRepository;
        $this->doorToDoorServiceRepository = $doorToDoorServiceRepository;
        $this->doorToDoorOrderRepository = $doorToDoorOrderRepository;
        $this->invoiceRepository = $invoiceRepository;
    }

    public function store(Request $request)
    {
        $doorToDoorService_id = $request->get('door_to_door_service_id');
        $doorToDoorService = $this->doorToDoorServiceRepository->find($doorToDoorService_id);
        
        $request->request->add([
            'customer_id' => $request->user()->id,
            'due_date' => date('Y-m-d H:i:s', strtotime('-1 day', strtotime($doorToDoorService->start))),
            'service' => 'Antar Kota',
        ]);
        // $request->request->add(['invoice_id' => $invoice->id]);

        $order = $this->doorToDoorOrderRepository->api_store($request);
        $this->doorToDoorServiceRepository->route_ready_false($doorToDoorService);

        $request->request->add(['door_to_door_order_id' => $order->id]);
        $invoice = $this->invoiceRepository->store($request);

        return response()->json(['message'=>'Tiket berhasil dipesan'], $this->successStatus);
    }

    public function get_orders(Request $request)
    {
        $orders = new DoorToDoorOrderListCollection($this->doorToDoorOrderRepository->get_orders($request));

        return response()->json($orders, 200);
    }

    public function get_history(Request $request)
    {
        $orders = new DoorToDoorOrderListCollection($this->doorToDoorOrderRepository->get_history($request));

        return response()->json($orders, 200);
    }

    public function show($doorToDoorOrder_id)
    {
        $orders = new DoorToDoorOrderItem($this->doorToDoorOrderRepository->find($doorToDoorOrder_id));

        return response()->json($orders, 200);
    }

    public function update(Request $request, $doorToDoorOrder_id)
    {
        $orders = $this->doorToDoorOrderRepository->find($doorToDoorOrder_id);
        $this->doorToDoorOrderRepository->update($request, $orders);

        return response()->json(['message' => 'Data diperbaharui'], 200);
    }
}
