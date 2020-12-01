<?php

namespace App\Providers;

use App\Contracts\SwapiApiContract;
use App\Contracts\SwapiAuthorizationContract;
use App\Contracts\SwapiCacheContract;
use App\Contracts\SwapiRepositoryContract;
use App\Swapi\SwapiApi;
use App\Swapi\SwapiAuthorization;
use App\Swapi\SwapiCacheDBDriver;
use App\Swapi\SwapiRepository;
use GuzzleHttp\Client;
use Illuminate\Support\ServiceProvider;

class SwapiServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton(SwapiApiContract::class, function () {
            $httpClient = new Client([
                "base_uri" => trim(config('swapi.url'), '/'),
            ]);

            return new SwapiApi($httpClient);
        });

        $this->app->singleton(SwapiCacheContract::class, function () {
            return new SwapiCacheDBDriver(config('swapi.cache_time'));
        });

        $this->app->singleton(SwapiRepositoryContract::class, function ($app) {
            return new SwapiRepository(
                $app->make(SwapiCacheContract::class),
                $app->make(SwapiApiContract::class),
            );
        });

        $this->app->singleton(SwapiAuthorizationContract::class, function ($app) {
            return new SwapiAuthorization;
        });
    }
}
