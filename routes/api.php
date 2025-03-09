<?php

use App\Http\Controllers\Api\AbsensiController;
use App\Http\Controllers\Api\JabatanController;
use App\Http\Controllers\Api\KaryawanController;
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

// Bagian Route Jabatan //
Route::get('jabatan',[JabatanController::class,'index']);
Route::get('jabatan/{id}',[JabatanController::class,'show']);
Route::post('jabatan',[JabatanController::class,'store']);
Route::put('jabatan/{id}',[JabatanController::class,'update']);
Route::delete('jabatan/{id}',[JabatanController::class,'destroy']);

// Bagian Route Karyawan //
Route::get('karyawan',[KaryawanController::class,'index']);
Route::get('karyawan/{id}',[KaryawanController::class,'show']);
Route::post('karyawan',[KaryawanController::class,'store']);
Route::put('karyawan/{id}',[KaryawanController::class,'update']);
Route::delete('karyawan/{id}',[KaryawanController::class,'destroy']);

//bagian Route Absenisasi //
Route::get('absen',[AbsensiController::class,'index']);
Route::get('absen/{id}',[AbsensiController::class,'show']); 
Route::post('absen',[AbsensiController::class,'store']);
Route::put('absen/{id}',[AbsensiController::class,'update']); 
Route::delete('absen/{id}',[AbsensiController::class,'destroy']); 