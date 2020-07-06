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
        return $this->model->where('door_to_door_service_id', $doorToDoorService_id)->orderBy('id', 'asc')->get();
    }

    public function passenger_orderBy_pickup($doorToDoorService_id)
    {
        return $this->model->where('door_to_door_service_id', $doorToDoorService_id)->whereNotNull('pickup_sequence')->orderBy('pickup_sequence', 'asc')->get();
    }

    public function passenger_orderBy_dropoff($doorToDoorService_id)
    {
        return $this->model->where('door_to_door_service_id', $doorToDoorService_id)->whereNotNull('dropoff_sequence')->orderBy('dropoff_sequence', 'asc')->get();
    }

    public function getPaymentStatus()
    {
        return $this->model->getPaymentStatus();
    }

    public function getLocationStatus()
    {
        return $this->model->getLocationStatus();
    }

    public function store(DoorToDoorOrderStoreRequest $request)
    {
        DB::beginTransaction();

        try {
            $this->model->create($request->all());
            DB::commit();
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
            return $doorToDoorOrder;
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