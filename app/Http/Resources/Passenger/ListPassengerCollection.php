<?php

namespace App\Http\Resources\Passenger;

use Illuminate\Http\Resources\Json\ResourceCollection;

class ListPassengerCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return ListPassengerItem::collection($this->collection);
    }
}
