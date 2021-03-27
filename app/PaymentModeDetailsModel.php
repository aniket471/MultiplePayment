<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PaymentModeDetailsModel extends Model
{
    protected $table = 'payment_mode_details';
    protected $fillable = [
        'payment_mode_details_title',
        'payment_mode_details_description',
        'payment_details_id'
    ];
}
