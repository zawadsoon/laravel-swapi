<?php

namespace Feature\Swapi;

use App\Swapi\SwapiAuthorization;
use Illuminate\Support\Facades\File;
use Tests\TestCase;

class SwapiAuthorizationTest extends TestCase
{
    /** @test */
    public function all_should_return_true_if_has()
    {
        $hero = $this->getHero();
        $auth = new SwapiAuthorization();
        $this->assertTrue($auth->hasVehicle($hero, 14));
        $this->assertTrue($auth->hasSpecies($hero, 1));
        $this->assertTrue($auth->hasStarShip($hero, 12));
        $this->assertTrue($auth->hasPlanet($hero, 1));
        $this->assertTrue($auth->hasFilm($hero, 2));
    }

    /** @test */
    public function all_should_return_false_if_is_missing()
    {
        $hero = $this->getHero();
        $auth = new SwapiAuthorization();
        $this->assertFalse($auth->hasVehicle($hero, 1));
        $this->assertFalse($auth->hasSpecies($hero, 2));
        $this->assertFalse($auth->hasStarShip($hero, 13));
        $this->assertFalse($auth->hasPlanet($hero, 2));
        $this->assertFalse($auth->hasFilm($hero, 11));
    }

    private function getHero()
    {
        return json_decode(File::get(resource_path('responses/people-1.json')));
    }
}
