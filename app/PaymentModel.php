<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PaymentModel extends Model
{
    protected $table = "payment_master";
    protected $fillable = [
        'payment_id',
        'payment_mode_id',
        'amount',
        'payment_for_purpose_id',
        'created_at'
    ];
}
