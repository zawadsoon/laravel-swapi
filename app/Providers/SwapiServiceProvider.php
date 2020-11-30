<?php

namespace App\Providers;

use App\Contracts\SwapiApiContract;
use App\Contracts\SwapiCacheContract;
use App\Swapi\SwapiApi;
use App\Swapi\SwapiCacheDBDriver;
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
    }
}
