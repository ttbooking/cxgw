<?php

namespace App\Providers;

use GuzzleHttp\Client as GuzzleClient;
use Http\Discovery\Psr18ClientDiscovery;
use Http\Discovery\Strategy\CommonPsr17ClassesStrategy;
use Http\Discovery\Strategy\DiscoveryStrategy;
use Illuminate\Support\ServiceProvider;
use Psr\Http\Client\ClientInterface;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Psr18ClientDiscovery::prependStrategy(
            new class implements DiscoveryStrategy
            {
                public static function getCandidates($type): array
                {
                    return match ($type) {
                        ClientInterface::class => [[
                            'class' => static fn () => new GuzzleClient([
                                'timeout' => 3,
                                'connect_timeout' => 1,
                            ]),
                            'condition' => static fn () => class_exists(GuzzleClient::class),
                        ]],
                        default => CommonPsr17ClassesStrategy::getCandidates($type),
                    };
                }
            }
        );
    }
}
