<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BeerController;

Route::get('/', [BeerController::class, 'index'])->name('beers.index');