<?php

namespace App\Contracts;

interface HeroCacheContract
{
    public function set($url, $data);
    public function get($url);
}
