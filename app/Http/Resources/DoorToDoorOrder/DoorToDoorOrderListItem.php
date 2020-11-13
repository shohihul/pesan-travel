<?php

namespace App\Http\Resources\DoorToDoorOrder;

use Illuminate\Http\Resources\Json\JsonResource;

class DoorToDoorOrderListItem extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $origin = $this->doorToDoorService->origin->name;
        $destination = $this->doorToDoorService->destination->name;

        $wordlist = array("Kabupaten ", "Kota ");
        foreach ($wordlist as $word) {
            $origin = str_replace($word, "", $origin);
            $destination = str_replace($word, "", $destination);
        }
        $route = $origin . ' - ' . $destination;
        
        return [
            'id' => $this->id,
            'location_point_status' => $this->location_point_status,
            'status' => $this->status,
            'invoice_status' => $this->invoice->status,
            'route' => $route,
            'start' => $this->doorToDoorService->start,
        ];
    }
}
