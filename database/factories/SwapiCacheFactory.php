<?php

namespace Database\Factories;

use App\Models\SwapiCache;
use Illuminate\Database\Eloquent\Factories\Factory;

class SwapiCacheFactory extends Factory
{
    protected $model = SwapiCache::class;

    public function definition()
    {
        return [
            'key' => $this->faker->unique()->word(),
            'value' => $this->faker->sentence(),
        ];
    }
}
