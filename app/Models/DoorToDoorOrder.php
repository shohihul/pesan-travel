<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DoorToDoorOrder extends Model
{
    protected $fillable = [
        'customer_id', 'door_to_door_service_id', 'pick_up_point', 'drop_off_point', 'location_point_status', 'location_point_note', 'quantity', 'payment_status', 'amount'
    ];

    public function getPaymentStatus()
    {
        return [
            'new' => 'Belum Dibayar',
            'on process' => 'Butuh DIkonfirmasi',
            'paid off' => 'Lunas'
        ];
    }

    public function getLocationStatus()
    {
        return [
            'new' => 'Butuh Dikonfirmasi',
            'rejected' => 'Ditolak',
            'approved' => 'Disetujui'
        ];
    }

    public function user() {
        return $this->belongsTo('App\User', 'customer_id');
    }

    public function doorToDoorService()
    {
        return $this->belongsTo(DoorToDoorService::class);
    }
}
