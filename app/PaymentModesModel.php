<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PaymentModesModel extends Model
{
    protected $table = "payment_modes";
    protected $fillable = [
        'payment_mode_id',
        'payment_mode'
    ];
}
