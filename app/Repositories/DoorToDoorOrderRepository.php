<?php

namespace App\Repositories;

use App\Models\DoorToDoorOrder;
use App\Http\Requests\DoorToDoorOrderStoreRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DoorToDoorOrderRepository
{
	protected $model;

	public function __construct(DoorToDoorOrder $model)
	{
	    $this->model = $model;
    }

    public function find($doorToDoorOrder_id)
	{
		return $this->model->find($doorToDoorOrder_id);
    }
    
    public function get_by_user(Request $request)
    {
        return $this->model->where('customer_id', $request->user()->id)->get();
    }

    public function get_orders(Request $request)
    {
        return $this->model->where('status', 'on_travel')
            ->where('customer_id', $request->user()->id)
            ->orWhere('status', 'new')
            ->where('customer_id', $request->user()->id)
            ->get();
    }

    public function get_history(Request $request)
    {
        return $this->model->where('status', 'cencel')
            ->orWhere('status', 'done')
            ->where('customer_id', $request->user()->id)
            ->get();
    }

    public function get_all()
    {
        return $this->model->all();
    }

    public function get_paginate($per_page)
    {
        return $this->model->paginate($per_page);
    }

    public function find_door_to_door_service_id($doorToDoorService_id)
    {
        return $this->model->where('door_to_door_service_id', $doorToDoorService_id)
            ->orderBy('id', 'asc')
            ->get();
    }

    public function bookers($doorToDoorService_id)
    {
        return $this->model->where('door_to_door_service_id', $doorToDoorService_id)
            ->where('location_point_status', '<>', 'approved')
            ->orWhereHas('invoice', function($invoice) {
                $invoice->where('status', '<>', 'paid_off');
            })
            ->where('door_to_door_service_id', $doorToDoorService_id)
            ->orderBy('id', 'asc')
            ->get();
    }

    public function passenger($doorToDoorService_id)
    {
        return $this->model->where('door_to_door_service_id', $doorToDoorService_id)
            ->where('status', '<>', 'cencel')
            ->where('location_point_status', 'approved')
            ->whereHas('invoice', function($invoice) {
                $invoice->where('status', 'paid_off');
            })
            ->orderBy('id', 'asc')
            ->get();
    }

    public function passenger_orderBy_pickup($doorToDoorService_id)
    {
        return $this->model->where('door_to_door_service_id', $doorToDoorService_id)
            ->whereNotNull('pickup_sequence')
            ->orderBy('pickup_sequence', 'asc')
            ->get();
    }

    public function passenger_orderBy_dropoff($doorToDoorService_id)
    {
        return $this->model->where('door_to_door_service_id', $doorToDoorService_id)
            ->whereNotNull('dropoff_sequence')
            ->orderBy('dropoff_sequence', 'asc')
            ->get();
    }

    public function getLocationStatus()
    {
        return $this->model->getLocationStatus();
    }

    public function getStatus()
    {
       return $this->model->getStatus(); 
    }

    public function get_qty_confirmed($doorToDoorService_id)
    {
        return $this->model
            ->where('door_to_door_service_id', $doorToDoorService_id)
            ->whereHas('invoice', function($invoice) {
                $invoice->where('status', 'paid_off');
            })
            ->sum('quantity');
    }

    public function store(DoorToDoorOrderStoreRequest $request)
    {
        DB::beginTransaction();

        try {
            $order = $this->model->create($request->all());
            DB::commit();
            return $order;
        } catch (\Exception $e) {
            DB::rollBack();
            throw new \Exception($e);
        }
    }

    public function api_store(Request $request)
    {
        DB::beginTransaction();

        try {
            $order = $this->model->create($request->all());
            DB::commit();
            return $order;
        } catch (\Exception $e) {
            DB::rollBack();
            throw new \Exception($e);
        }
    }

    public function update(Request $request, DoorToDoorOrder $doorToDoorOrder)
    {
        DB::beginTransaction();

        try {
            $doorToDoorOrder->update($request->all());
            DB::commit();
            return $doorToDoorOrder;
        } catch (\Exception $e) {
            DB::rollBack();
            throw new \Exception($e);
        }
    }

    public function delete(DoorToDoorOrder $doorToDoorOrder)
    {
        DB::beginTransaction();

        try {
            $doorToDoorOrder->delete();
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            throw new \Exception($e);
        }
    }

    public function update_sequence(DoorToDoorOrder $passenger_updated, $pickup, $dropoff)
    {
        $passenger_updated->pickup_sequence = $pickup;
        $passenger_updated->dropoff_sequence = $dropoff;
        $passenger_updated->save();
    }
}