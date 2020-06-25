<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Regencie extends Model
{
    public function DoorToDoorService() {
        return $this->hasMany(DoorToDoorService::class);
    }
}
