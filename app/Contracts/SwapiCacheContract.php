<?php

namespace App\Contracts;

interface SwapiCacheContract
{
    public function set($url, $data);
    public function get($url);
}
