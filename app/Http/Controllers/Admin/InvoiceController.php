<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\InvoiceRepository;
use App\Models\Invoice;

class InvoiceController extends Controller
{
    private $invoiceRepository;

    public function __construct (InvoiceRepository $invoiceRepository)
    {
        $this->middleware('roles:admin');
        $this->invoiceRepository = $invoiceRepository;
    }

    public function ajax_update(Request $request, Invoice $invoice)
    {
        $response = "Status tagihan berhasil diperbaharui";
        $this->invoiceRepository->update($request, $invoice);

        return response()->json($response);
    }
}
