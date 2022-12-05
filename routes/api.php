<?php

use App\Helpers\Response;
use App\Http\Controllers\Api\AbsensiController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\JabatanController;
use App\Http\Controllers\Api\KaryawanController;
use App\Http\Controllers\Api\KelolaGajiController;
use App\Http\Controllers\Api\KeluargaController;
use App\Http\Controllers\Api\KomponenController;
use App\Http\Controllers\Api\PotonganController;
use App\Http\Controllers\Api\RunPayrollController;
use App\Http\Controllers\Api\LaporanController;
use App\Http\Controllers\Api\TunjanganController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\DashboardController;
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
Route::group(['prefix'=>'karyawan','as'=>'karyawan','middleware'=>'auth:api'],function(){
    Route::get('/',[KaryawanController::class,'index']);
    Route::get('/detail',[KaryawanController::class,'show']);
    Route::post('/',[KaryawanController::class,'store']);
    Route::put('/',[KaryawanController::class,'update']);
    Route::delete('/',[KaryawanController::class,'destroy']);
});

// api jabatan
Route::group(['prefix'=>'jabatan','as'=>'jabatan','middleware'=>'auth:api'],function(){
    Route::get('/',[JabatanController::class,'index']);
    Route::post('/',[JabatanController::class,'store']);
    Route::put('/',[JabatanController::class,'update']);
    Route::delete('/',[JabatanController::class,'destroy']);
});

// api komponent
Route::group(['prefix'=>'komponen','as'=>'komponen','middleware'=>'auth:api'],function(){
    Route::get('/',[KomponenController::class,'index']);
    Route::post('/',[KomponenController::class,'store']);
    Route::put('/',[KomponenController::class,'update']);
    Route::delete('/',[KomponenController::class,'destroy']);
});

//api absensi
Route::group(['prefix'=>'absen','as'=>'absen','middleware'=>'auth:api'],function(){
    Route::get('/',[AbsensiController::class,'index']);
    Route::post('/',[AbsensiController::class,'store']);
    Route::put('/',[AbsensiController::class,'update']);
    Route::delete('/',[AbsensiController::class,'destroy']);
});


//api tunjangan
Route::group(['prefix'=>'tunjangan','as'=>'tunjangan','middleware'=>'auth:api'],function(){
    Route::get('/',[TunjanganController::class,'index']);
    Route::post('/',[TunjanganController::class,'store']);
    Route::put('/',[TunjanganController::class,'update']);
    Route::delete('/',[TunjanganController::class,'destroy']);
});


//api potongan
Route::group(['prefix'=>'potongan','as'=>'potongan','middleware'=>'auth:api'],function(){
    Route::get('/',[PotonganController::class,'index']);
    Route::post('/',[PotonganController::class,'store']);
    Route::put('/',[PotonganController::class,'update']);
    Route::delete('/',[PotonganController::class,'destroy']);
});

//api keluarga
Route::group(['prefix'=>'keluarga','as'=>'keluarga','middleware'=>'auth:api'],function(){
    Route::get('/',[KeluargaController::class,'index']);
    Route::post('/',[KeluargaController::class,'store']);
    Route::put('/',[KeluargaController::class,'update']);
    Route::delete('/',[KeluargaController::class,'destroy']);
});

//api user
Route::group(['prefix'=>'user','as'=>'user','middleware'=>'auth:api'],function(){
    Route::get('/',[UserController::class,'index']);
    Route::post('/',[UserController::class,'store']);
    Route::put('/',[UserController::class,'update']);
    Route::delete('/',[UserController::class,'destroy']);
});

//api kelola gaji
Route::group(['prefix'=>'kelola-gaji','as'=>'kelola-gaji','middleware'=>'auth:api'],function(){
    Route::post('/',[KelolaGajiController::class,'postMulti']);
    Route::get('/',[KelolaGajiController::class,'index']);
});

// report
Route::group(['prefix'=>'laporan','as'=>'laporan','middleware'=>'auth:api'],function(){
    Route::get('/gaji',[LaporanController::class,'gaji']);
    Route::get('/absen',[LaporanController::class,'absen']);
    Route::get('/slip',[LaporanController::class,'slip']);
});

// route dashboard
Route::group(['prefix'=>'dashboard'],function(){
    Route::get('/',[DashboardController::class,'dashboard']);
});

// run payroll
Route::post('run-payroll',[RunPayrollController::class,'run']);

// api login
Route::post('login',[AuthController::class,'login'])->name('login');
Route::post('register',[AuthController::class,'register']);

Route::get('unauthorized',function(){
    $data = [
        'message'=>'Unauthorized',
        'data'=>[]
    ];
    return Response::send(401,$data);
})->name('unauthorized');
