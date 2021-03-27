<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PaymentForPurposeModel extends Model
{
    protected $table = "payment_for_purpose";
    protected $fillable = [
        'payment_for_purpose_id',
        'payment_for_title'
    ];
}
