<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DoorToDoorService extends Model
{
    protected $fillable = [
        'car_id', 'origin_id', 'destination_id', 'price', 'start', 'finish'
    ];

    public static function getRouteStatus(){
        return [
            1 => 'Tersedia',
            0 => 'Belum Tersedia'
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
}
