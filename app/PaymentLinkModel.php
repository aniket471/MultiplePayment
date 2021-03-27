<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PaymentLinkModel extends Model
{
    protected $table = "payment_links";
    protected $fillable = [
        'lead_id',
        'payment_for_purpose'
    ];
}
