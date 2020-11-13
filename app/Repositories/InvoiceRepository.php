<?php

namespace App\Repositories;

use App\Models\Invoice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class InvoiceRepository
{
    protected $model;

	public function __construct(Invoice $model)
	{
	    $this->model = $model;
    }

    public function get_by_order_id($order_id)
    {
        return $this->model->whereIn('door_to_door_order_id', $order_id)
            ->orderByRaw("FIELD(status, 'cencel', 'paid_off', 'on_process', 'new', 'rejected') DESC")
            ->get();
    }

    public function getInvoiceStatus()
    {
        return $this->model->getInvoiceStatus();
    }

    public function store(Request $request)
    {
        DB::beginTransaction();

        try {
            $invoice = $this->model->create($request->all());
            DB::commit();
            return $invoice;
        } catch (\Exception $e) {
            DB::rollBack();
            throw new \Exception($e);
        }
    }

    public function update(Request $request, Invoice $invoice)
    {
        DB::beginTransaction();

        try {
            $invoice->update($request->all());
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            throw new \Exception($e);
        }
    }
}