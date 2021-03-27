<?php
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('index','BookingController@index');
Route::get('getData','BookingController@getData');
Route::get('getPaymentsByBooking','BookingController@getPaymentsByBooking');
Route::post('editPaymentDetails','BookingController@editPaymentDetails');
Route::get('checkBookingModel','BookingController@checkBookingModel');
Route::get('getBookingId','BookingController@getBookingId');
Route::get('getData','BookingController@getData');