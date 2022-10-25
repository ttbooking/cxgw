<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use TTBooking\CurrencyExchange\Facades\ExchangeRate;

class ExchangeRateController
{
    public function getExchangeRate(string $base, string $quote, Request $request): \JsonSerializable
    {
        $service = $request->query('service');
        $options = array_filter(compact('service'));

        return ExchangeRate::provider($service)->get("$base/$quote", $request->query('date'), $options);
    }
}
