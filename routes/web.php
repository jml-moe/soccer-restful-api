<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\TimController;
use App\Http\Controllers\API\LigaController;
use App\Http\Controllers\API\PertandinganController;

Route::get('/', function () {
    return view('welcome');
});


