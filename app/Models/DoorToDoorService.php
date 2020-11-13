<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DoorToDoorService extends Model
{
    protected $fillable = [
        'car_id', 'origin_id', 'destination_id', 'price', 'start', 'finish', 'route_ready'
    ];

    public function getStatus()
    {
        return [
            'open' => 'Buka',
            'close' => 'Tutup',
            'on_travel' => 'Dalam Perjalanan',
            'done' => 'Selesai'
        ];
    }

    public function origin() {
        return $this->belongsTo(Regencie::class, 'origin_id');
    }

    public function destination() {
        return $this->belongsTo(Regencie::class, 'destination_id');
    }

    public function car() {
        return $this->belongsTo(Car::class);
    }

    public function doorToDoorOrder() {
        return $this->hasMany(DoorToDoorOrder::class);
    }

    public function driver()
    {
        return $this->belongsTo('App\User', 'driver_id');
    }
}
