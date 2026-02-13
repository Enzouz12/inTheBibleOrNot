<?php

use App\Http\Controllers\BibleWordController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::post('/check-words', [BibleWordController::class, 'check']);
