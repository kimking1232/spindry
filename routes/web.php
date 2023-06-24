<?php

use App\Http\Controllers\HeroController;
use App\Http\Controllers\PromotionController;
use App\Http\Controllers\PartnerController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

//Page Register
Route::get('/register', [UserController::class, 'createRegister']);
Route::post('/register', [UserCOntroller::class, 'storeRegister']);

//Page Login
Route::get('/login', [UserController::class, 'login'])->name('login');
Route::post('/login', [UserController::class, 'prosesLogin']);

Route::get('/dashboard', function () {
    return view('pages.dashboard');
})->middleware('auth');

// Page Hero
Route::get('/hero', [HeroController::class, 'index']);
Route::get('/hero/create', [HeroController::class, 'create']);
Route::post('/hero', [HeroController::class, 'store']);
Route::get('/hero/{hero}/edit', [HeroController::class, 'edit']);
Route::put('/hero/{hero}', [HeroController::class, 'update']);
Route::delete('/hero/{hero}', [HeroController::class, 'destroy']);

//Page Promotion
Route::get('/promotion', [PromotionController::class, 'index']);
Route::get('/promotion/create', [PromotionController::class, 'create']);
Route::post('/promotion', [PromotionController::class, 'store']);
Route::get('/promotion/{promotion}/edit', [PromotionController::class, 'edit']);
Route::put('/promotion/{promotion}', [PromotionController::class, 'update']);
Route::delete('/promotion/{promotion}', [PromotionController::class, 'destroy']);

//Page Partner
Route::get('/partner', [PartnerController::class, 'index']);
Route::get('/partner/create', [PartnerController::class, 'create']);
Route::post('partner', [PartnerController::class, 'store']);
Route::get('/partner/{partner}/edit', [PartnerController::class, 'edit']);
Route::put('/partner/{partner}', [PartnerController::class, 'update']);
Route::delete('/partner/{partner}', [PartnerController::class, 'destroy']);

//Page Service
Route::get('/service', [ServiceController::class, 'index']);
Route::get('/service/create', [ServiceController::class, 'create']);
Route::post('/service', [ServiceController::class, 'store']);
Route::get('/service/{service}/edit', [ServiceController::class, 'edit']);
Route::put('/service/{service}', [ServiceController::class, 'update']);
Route::delete('/service/{service}', [ServiceController::class, 'destroy']);

Route::get('/logout', [UserController::class, 'logout'])->middleware('auth');
