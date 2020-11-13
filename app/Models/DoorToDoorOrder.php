<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DoorToDoorOrder extends Model
{
    protected $fillable = [
        'customer_id',
        'door_to_door_service_id',
        'pickup_point',
        'dropoff_point',
        'location_point_status',
        'admin_note',
        'location_note',
        'quantity',
        'status',
        'payment_status',
    ];

    public function getLocationStatus()
    {
        return [
            'new' => 'Butuh Dikonfirmasi',
            'rejected' => 'Ditolak',
            'approved' => 'Disetujui'
        ];
    }

    public function getStatus()
    {
        return [
            'new' => 'Terdaftar',
            'cencel' => 'Dibatalkan',
            'on_travel' => 'Dalam Perjalanan',
            'done' => 'Selesai'
        ];
    }

    public function user() {
        return $this->belongsTo('App\User', 'customer_id');
    }

    public function doorToDoorService()
    {
        return $this->belongsTo(DoorToDoorService::class);
    }

    public function invoice()
    {
        return $this->hasOne(Invoice::class);
    }
}
