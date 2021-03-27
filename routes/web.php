<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BookingController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});
Route::get('/export_excel',[BookingController::class ,'index']);
Route::get('/export_excel/excel',[BookingController::class,'excel'])->name('export_excel.excel');
Route::get('importExportView', [BookingController::class, 'importExportView' ]);

Route::get('users', ['uses'=>'UserController@index', 'as'=>'users.index']);
