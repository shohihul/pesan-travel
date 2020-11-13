<?php

namespace App\Http\Resources\TaskDriver;

use Illuminate\Http\Resources\Json\JsonResource;

class ListTaskDriverItem extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $origin = $this->origin->name;
        $destination = $this->destination->name;

        $wordlist = array("Kabupaten ", "Kota ");
        foreach ($wordlist as $word) {
            $origin = str_replace($word, "", $origin);
            $destination = str_replace($word, "", $destination);
        }
        $route = $origin . ' - ' . $destination;

        return [
            'service_id' => $this->id,
            'origin' => $origin,
            'destination' => $destination,
            'start' => $this->start,
            'route_ready' => $this->route_ready,
            'task_status' => $this->status,
            'passenger_count' => $this->passenger_count,
            'car_name' => $this->car->name,
            'car_capacity' => $this->car->capacity
        ];
    }
}
