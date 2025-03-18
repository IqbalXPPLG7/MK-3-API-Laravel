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
Route::apiResource('jabatan',JabatanController::class);

// Bagian Route Karyawan //
Route::apiResource('karyawan',KaryawanController::class);

//bagian Route Absenisasi //
Route::apiResource('absen',AbsensiController::class);