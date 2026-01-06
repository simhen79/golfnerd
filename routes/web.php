<?php

use App\Http\Controllers\PublicStatsController;
use Illuminate\Support\Facades\Route;

Route::get('/', [PublicStatsController::class, 'index'])->name('home');
