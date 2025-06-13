<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TimController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\LigaController;
use App\Http\Controllers\KlasemenController;
use App\Http\Controllers\PertandinganController;

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
// Routes untuk Liga
Route::middleware('cektoken')->prefix('liga')->group(function () {
    Route::get('/', [LigaController::class, 'index']);
    Route::post('/', [LigaController::class, 'store']);
    Route::get('/{id}', [LigaController::class, 'show']);
    Route::put('/{id}', [LigaController::class, 'update']);
    Route::delete('/{id}', [LigaController::class, 'destroy']);
});

// Routes untuk Tim
Route::middleware('cektoken')->prefix('tim')->group(function () {
    Route::get('/', [TimController::class, 'index']);
    Route::post('/', [TimController::class, 'store']);
    Route::get('/{id}', [TimController::class, 'show']);
    Route::put('/{id}', [TimController::class, 'update']);
    Route::delete('/{id}', [TimController::class, 'destroy']);
});

// Routes untuk Pertandingan
Route::middleware('cektoken')->prefix('pertandingan')->group(function () {
    Route::get('/', [PertandinganController::class, 'index']);
    Route::post('/', [PertandinganController::class, 'store']);
    Route::get('/{id}', [PertandinganController::class, 'show']);
    Route::put('/{id}', [PertandinganController::class, 'update']);
    Route::delete('/{id}', [PertandinganController::class, 'destroy']);
});

// Routes untuk Klasemen
Route::middleware('cektoken')->prefix('klasemen')->group(function () {
    Route::get('/', [KlasemenController::class, 'index']);
    Route::post('/', [KlasemenController::class, 'store']);
    Route::get('/{id}', [KlasemenController::class, 'show']);
    Route::put('/{id}', [KlasemenController::class, 'update']);
    Route::delete('/{id}', [KlasemenController::class, 'destroy']);
});

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::middleware('cektoken')->group(function () {
    Route::get('/me', [AuthController::class, 'me']);
    Route::post('/logout', [AuthController::class, 'logout']);  
});