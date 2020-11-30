<?php

namespace App\Contracts;

interface SwapiCacheContract
{
    public function set($key, $value);
    public function get($key);
}
