<?php

use App\Http\Controllers\ExchangeRateController;
use Illuminate\Support\Facades\Route;

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

Route::get('/rate/{base}/{quote}', [ExchangeRateController::class, 'getExchangeRate'])
    ->where(['base' => '[A-Z]{3}', 'quote' => '[A-Z]{3}']);
