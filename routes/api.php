<?php

use App\Http\Controllers\ExchangeRateController;
use Illuminate\Support\Facades\Route;

Route::get('/rate/{base}/{quote}', [ExchangeRateController::class, 'getExchangeRate'])
    ->where(['base' => '[A-Z]{3}', 'quote' => '[A-Z]{3}']);
