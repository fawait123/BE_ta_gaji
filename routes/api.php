<?php

use App\Http\Controllers\Api\AbsensiController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\JabatanController;
use App\Http\Controllers\Api\KaryawanController;
use App\Http\Controllers\Api\KomponenController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// api karyawan
Route::group(['prefix'=>'karyawan','as'=>'karyawan'],function(){
    Route::get('/',[KaryawanController::class,'index']);
    Route::post('/',[KaryawanController::class,'store']);
    Route::put('/',[KaryawanController::class,'update']);
    Route::delete('/',[KaryawanController::class,'destroy']);
});

// api jabatan
Route::group(['prefix'=>'jabatan','as'=>'jabatan'],function(){
    Route::get('/',[JabatanController::class,'index']);
    Route::post('/',[JabatanController::class,'store']);
    Route::put('/',[JabatanController::class,'update']);
    Route::delete('/',[JabatanController::class,'destroy']);
});

// api komponent
Route::group(['prefix'=>'komponen','as'=>'komponen'],function(){
    Route::get('/',[KomponenController::class,'index']);
    Route::post('/',[KomponenController::class,'store']);
    Route::put('/',[KomponenController::class,'update']);
    Route::delete('/',[KomponenController::class,'destroy']);
});

//api absensi
Route::group(['prefix'=>'absen','as'=>'absen'],function(){
    Route::get('/',[AbsensiController::class,'index']);
    Route::post('/',[AbsensiController::class,'store']);
    Route::put('/',[AbsensiController::class,'update']);
    Route::delete('/',[AbsensiController::class,'destroy']);
});
