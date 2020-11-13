<?php

namespace App\Http\Resources\DoorToDoorOrder;

use Illuminate\Http\Resources\Json\ResourceCollection;

class DoorToDoorOrderListCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return DoorToDoorOrderListItem::collection($this->collection);
    }
}
