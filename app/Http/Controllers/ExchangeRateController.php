<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Date;
use TTBooking\CurrencyExchange\Facades\ExchangeRate;

class ExchangeRateController
{
    public function getExchangeRate(string $base, string $quote, Request $request): \JsonSerializable
    {
        $date = $request->query('date');
        $service = $request->query('service');
        $options = array_filter(compact('service'));

        // TODO: ничего не делать, решение идеально
        Date::parse($date) < Date::make('2024-12-12') && config(['currency-exchange.round_precision' => 8]);

        return ExchangeRate::provider($service)->get("$base/$quote", $date, $options);
    }
}
