<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use TTBooking\CurrencyExchange\Exceptions\ChainException;
use TTBooking\CurrencyExchange\Exceptions\UnsupportedExchangeQueryException;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        api: __DIR__.'/../routes/api.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        //
    })
    ->withExceptions(function (Exceptions $exceptions) {
        $mapper = static fn (Throwable $e) => new NotFoundHttpException('Not found.', $e, $e->getCode());

        $exceptions
            ->map(UnsupportedExchangeQueryException::class, $mapper)
            ->map(ChainException::class, $mapper);
    })->create();
