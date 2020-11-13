<?php

namespace App\Http\Resources\DoorToDoorOrder;

use Illuminate\Http\Resources\Json\ResourceCollection;

class DoorToDoorOrderCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return DoorToDoorOrderItem::collection($this->collection);
    }
}
