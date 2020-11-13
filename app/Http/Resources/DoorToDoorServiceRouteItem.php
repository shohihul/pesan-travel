<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class DoorToDoorServiceRouteItem extends JsonResource
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

        // $wordlist = array("Kabupaten ", "Kota ");
        // foreach ($wordlist as $word) {
        //     $origin = str_replace($word, "", $origin);
        //     $destination = str_replace($word, "", $destination);
        // }
        
        return [
            'origin_id' => $this->origin_id,
            'destination_id' => $this->destination_id,
            'origin' => $origin,
            'destination' => $destination,
        ];
    }
}
