<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\AppConfig;

class BookingModel extends Model
{
    protected $table = "booking_master";
    protected $fillable = [
        'booing_id',
        'payment_id',
        'payment_id_2',
        'payment_id_3',
        'payment_id_4',
        'payment_id_5',
        'sales_person_id',
        'lead_id',
        'remark'
    ];


  /*  const booking_master = 'booking_master';
    const booking_id = 'booking_id';
    const payment_id = 'payment_id';
    const payment_id_2 = 'payment_id_2';
    const payment_id_3 = 'payment_id_3';
    const payment_id_4 = 'payment_id_4';
    const payment_id_5 = 'payment_id_5';

    const booking_master_all = self::booking_master.AppConfig::DOT.AppConfig::STAR;
    const booking_master_booking_id = self::booking_master . AppConfig::DOT . self::booking_id;
    const booking_master_payment_id = self::booking_master . AppConfig::DOT . self::payment_id;
    const booking_master_payment_id_2 = self::booking_master . AppConfig::DOT . self::payment_id_2;
    const booking_master_payment_id_3 = self::booking_master . AppConfig::DOT . self::payment_id_3;
    const booking_master_payment_id_4 = self::booking_master . AppConfig::DOT . self::payment_id_4;
    const booking_master_payment_id_5 = self::booking_master . AppConfig::DOT . self::payment_id_5;

    protected $table = self::booking_master;
    protected $fillable = [
        self::booking_id,
        self::payment_id,
        self::payment_id_2,
        self::payment_id_3,
        self::payment_id_4,
        self::payment_id_5

    ];

    public static function getMultiPaymentByBooking($request){
        
        $booking_id = $request->input('booking_id');
        
    }*/
}
