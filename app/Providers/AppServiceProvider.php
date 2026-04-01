<?php
declare(strict_types=1);

namespace App\Providers;

use Http\Discovery\Strategy\CommonPsr17ClassesStrategy;
use Illuminate\Support\ServiceProvider;
use Http\Discovery\Psr18ClientDiscovery;
use Http\Discovery\Strategy\DiscoveryStrategy;
use Psr\Http\Client\ClientInterface;
use GuzzleHttp\Client as GuzzleClient;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // Регистрируем свою стратегию, которая всегда возвращает Guzzle с таймаутом
        Psr18ClientDiscovery::prependStrategy(
            new class implements DiscoveryStrategy {
                public static function getCandidates($type): array
                {
                    if ($type === ClientInterface::class) {
                        return [
                            [
                                'class' => fn() => new GuzzleClient([
                                    'timeout'         => 3,
                                    'connect_timeout' => 1,
                                ]),
                                'condition' => fn() => class_exists(GuzzleClient::class),
                            ]
                        ];
                    }

                    return CommonPsr17ClassesStrategy::getCandidates($type);
                }
            }
        );
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
