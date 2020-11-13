<?php

namespace App\Http\Resources\DoorToDoorOrder;

use Illuminate\Http\Resources\Json\JsonResource;

class DoorToDoorOrderItem extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $driver = $this->doorToDoorService->driver->name;
        $origin = $this->doorToDoorService->origin->name;
        $destination = $this->doorToDoorService->destination->name;

        $wordlist = array("Kabupaten ", "Kota ");
        foreach ($wordlist as $word) {
            $origin = str_replace($word, "", $origin);
            $destination = str_replace($word, "", $destination);
        }
        
        return [
            'id' => $this->id,
            'pickup_point' => $this->pickup_point,
            'dropoff_point' => $this->dropoff_point,
            'location_point_status' => $this->location_point_status,
            'location_note' => $this->location_note,
            'admin_note' => $this->admin_note,
            'quantity' => $this->quantity,
            'status' => $this->status,
            'pickup_sequence' => $this->pickup_sequence,
            'dropoff_sequence' => $this->dropoff_sequence,
            'invoice_status' => $this->invoice->status,
            'origin' => $origin,
            'destination' => $destination,
            'start' => $this->doorToDoorService->start,
            'driver_name' => $driver,
            'car_name' => $this->doorToDoorService->car->name,
            'car_capacity' => $this->doorToDoorService->car->capacity
        ];
    }
}
