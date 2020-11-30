<?php

namespace App\Swapi;

use App\Contracts\SwapiCacheContract;
use App\Exceptions\SwapiCacheExpiredException;
use App\Models\SwapiCache;

class SwapiCacheDBDriver implements SwapiCacheContract
{
    private $cacheTimeInSeconds;

    public function __construct($cacheTimeInSeconds)
    {
        $this->$cacheTimeInSeconds = $cacheTimeInSeconds;
    }

    public function set($key, $value)
    {
        $entry = SwapiCache::find($key);

        if (!$entry) {
            $entry = new SwapiCache();
            $entry->key = $key;
        }

        $entry->value = $value;
        $entry->cached_at = now();
        $entry->save();
    }

    public function get($key)
    {
        $entry = SwapiCache::find($key);

        if (is_null($entry)) {
            return null;
        }

        if ($this->isExpired($entry)) {
            throw new SwapiCacheExpiredException("Swapi cache entry expired, $key");
        }

        return $entry->value;
    }

    public function isExpired(SwapiCache $entry): bool
    {
        return now()->diffInSeconds($entry->cached_at) > $this->cacheTimeInSeconds;
    }
}
