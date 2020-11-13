<?php

namespace App\Http\Resources\TaskDriver;

use Illuminate\Http\Resources\Json\ResourceCollection;

class ListTaskDriverCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return ListTaskDriverItem::collection($this->collection);
    }
}
