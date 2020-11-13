<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Car extends Model
{
    protected $fillable = [
        'name', 'capacity', 'photo'
    ];

    public function doorToDoorService() {
        return $this->hasMany(DoorToDoorService::class);
    }
}
