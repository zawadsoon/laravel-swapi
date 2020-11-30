<?php

namespace App\Swapi;

use App\Contracts\SwapiCacheContract;
use App\Exceptions\SwapiCacheExpiredException;

class SwapiCacheDBDriver implements SwapiCacheContract
{
    public function set($url, $data)
    {
        //
    }

    public function get($url)
    {
        // TODO load from cache
        // TODO check if not stale
        // TODO throw if expired
        // throw new SwapiCacheExpiredException()
        // TODO return null if missing 
    }
}
