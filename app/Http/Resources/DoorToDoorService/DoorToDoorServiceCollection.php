<?php

namespace App\Http\Resources\DoorToDoorService;

use Illuminate\Http\Resources\Json\ResourceCollection;

class DoorToDoorServiceCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return DoorToDoorServiceItem::collection($this->collection);
    }
}
