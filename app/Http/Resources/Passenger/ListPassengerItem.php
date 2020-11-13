<?php

namespace App\Http\Resources\Passenger;

use Illuminate\Http\Resources\Json\JsonResource;

class ListPassengerItem extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        if ($this->user->photo == null) {
            $photo = '/assets/img/photo-profile/blank.png';
        } else {
            $photo = '/assets/img/photo-profile/' . $this->user->photo;
        }
        return [
            'id' => $this->id,
            'pickup_point' => $this->pickup_point,
            'dropoff_point' => $this->dropoff_point,
            'location_point_status' => $this->location_point_status,
            'location_note' => $this->location_note,
            'quantity' => $this->quantity,
            'status' => $this->status,
            'pickup_sequence' => $this->pickup_sequence,
            'dropoff_sequence' => $this->dropoff_sequence,
            'passenger' => $this->user->name,
            'passenger_photo' => $photo,
        ];
    }
}
