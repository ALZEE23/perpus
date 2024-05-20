<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/login', [App\Http\Controllers\Api\Auth\LoginController::class, 'index']);

Route::post('/pustakawan', [App\Http\Controllers\Api\Admin\PustakawanController::class,'store']);
Route::get('/pustakawan', [App\Http\Controllers\Api\Admin\PustakawanController::class,'index']);
Route::post('/user', [App\Http\Controllers\Api\Admin\UserController::class,'store']);
Route::get('/user', [App\Http\Controllers\Api\Admin\UserController::class,'index']);
Route::post('/data-buku', [App\Http\Controllers\Api\Admin\DataBukuController::class,'store']);
Route::get('/data-buku', [App\Http\Controllers\Api\Admin\DataBukuController::class,'index']);
Route::post('/peminjaman', [App\Http\Controllers\Api\User\PeminjamanController::class,'store']);
Route::get('/peminjaman', [App\Http\Controllers\Api\User\PeminjamanController::class,'index']);



Route::group(['middleware' => 'auth:api'], function(){
    Route::post('/logout', [App\Http\Controllers\Api\Auth\LoginController::class, 'logout']);
});