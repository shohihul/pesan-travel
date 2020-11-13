<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Invoice;
use App\Repositories\DoorToDoorOrderRepository;
use App\Repositories\InvoiceRepository;

use App\Http\Resources\InvoiceCollection;

class InvoiceController extends Controller
{
    public $successStatus = 200;
    
    private $doorToDoorOrderRepository;
    private $invoiceRepository;

    public function __construct (DoorToDoorOrderRepository $doorToDoorOrderRepository, InvoiceRepository $invoiceRepository)
    {
        $this->doorToDoorOrderRepository = $doorToDoorOrderRepository;
        $this->invoiceRepository = $invoiceRepository;
    }

    public function get_invoice(Request $request)
    {
        $order_id = [];
        $orders = $this->doorToDoorOrderRepository->get_by_user($request);

        foreach ($orders as $order) {
            array_push($order_id, $order->id);
        }

        $invoice = new InvoiceCollection($this->invoiceRepository->get_by_order_id($order_id));
        

        return response()->json($invoice, 200);
    }

    public function update(Request $request, Invoice $invoice)
    {
        $response = "Status tagihan berhasil diperbaharui";
        $this->invoiceRepository->update($request, $invoice);

        return response()->json(['message'=>'Tiket berhasil dipesan'], 200);
    }
}
