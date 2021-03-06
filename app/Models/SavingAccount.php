<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SavingAccount extends Model
{
    protected $fillable = [
        'bank_account',
        'account_name',
        'account_number',
        'logo',
    ];

    public function invoice() {
        return $this->hasMany(Invoice::class);
    }
}
