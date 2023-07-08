<?php

use Illuminate\Http\Request;
use App\Http\Controllers\HeroApiController;
use App\Http\Controllers\PartnerApiController;
use App\Http\Controllers\PromotionApiController;
use App\Http\Controllers\ServiceApiController;
use App\Http\Controllers\OrderApiController;
use App\Http\Controllers\UserApiController;
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

Route::post('/login', [UserApiController::class, 'login']);

Route::get('/hero', [HeroApiController::class, 'getData'])->middleware('auth:sanctum');
Route::get('/partner', [PartnerApiController::class, 'getData'])->middleware('auth:sanctum');
Route::get('/promotion', [PromotionApiController::class, 'getData'])->middleware('auth:sanctum');
Route::get('/service', [ServiceApiController::class, 'getData'])->middleware('auth:sanctum');

Route::resource('/order', OrderApiController::class)->except('create', 'show', 'edit', 'update')->middleware('auth:sanctum');
Route::get('/logout', [UserApiController::class, 'logout'])->middleware('auth:sanctum');
