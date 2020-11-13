<?php

namespace App\Http\Resources\DoorToDoorService;

use Illuminate\Http\Resources\Json\JsonResource;

class DoorToDoorServiceItem extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            "id" => $this->id,
            "origin" => $this->origin->name,
            "destination" => $this->destination->name,
            "price" => $this->price,
            "start" => $this->start,
            "finish" => $this->finish,
            "route_ready" => $this->route_ready,
            "status" => $this->status,
            "available" => $this->available
        ];
    }
}
