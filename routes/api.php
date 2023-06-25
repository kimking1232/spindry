<?php

use Illuminate\Http\Request;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\HeroApiController;
use App\Http\Controllers\PartnerApiController;
use App\Http\Controllers\PromotionApiController;
use App\Http\Controllers\ServiceApiController;
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

Route::get('/coba-api', [OrderController::class, 'index']);
Route::get('/hero', [HeroApiController::class, 'getData']);
Route::get('/partner', [PartnerApiController::class, 'getData']);
Route::get('/promotion', [PromotionApiController::class, 'getData']);
Route::get('/service', [ServiceApiController::class, 'getData']);
