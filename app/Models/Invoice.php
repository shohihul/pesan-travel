<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    protected $fillable = [
        'door_to_door_order_id',
        'status',
        'amount',
        'bank_account',
        'account_name',
        'transfer_date',
        'transfer_to',
        'service',
        'detail',
        'due_date'
    ];

    public function getInvoiceStatus()
    {
        return [
            'new' => 'Belum Dibayar',
            'rejected' => 'Ditolak',
            'cencel' => 'Dibatalkan',
            'on_process' => 'Butuh Dikonfirmasi',
            'paid_off' => 'Lunas'
        ];
    }

    public function doorToDoorOrder()
    {
        return $this->belongsTo(DoorToDoorOrder::class);
    }
    
    public function bank() {
        return $this->belongsTo(SavingAccount::class, 'transfer_to');
    }
}
