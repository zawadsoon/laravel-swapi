<?php

namespace App\Providers;

use App\Contracts\SwapiApiContract;
use App\Swapi\SwapiApi;
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
    }
}
