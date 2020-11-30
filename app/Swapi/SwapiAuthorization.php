<?php

namespace App\Swapi;

use App\Contracts\SwapiAuthorizationContract;

class SwapiAuthorization implements SwapiAuthorizationContract
{
    public function hasVehicle($hero, $vehicleId): bool
    {
        return $this->has($hero->vehicles, $vehicleId);
    }

    public function hasSpecies($hero, $speciesId): bool
    {
        return $this->has($hero->species, $speciesId);
    }

    public function hasStarShip($hero, $starShipId): bool
    {
        return $this->has($hero->starships, $starShipId);
    }

    public function hasPlanet($hero, $planetId): bool
    {
        return $this->has([$hero->homeworld], $planetId);
    }

    public function hasFilm($hero, $filmId): bool
    {
        return $this->has($hero->films, $filmId);
    }

    private function has($arr, $id): bool
    {
        for ($i = 0; $i < count($arr); $i++) {
            if (strpos($arr[$i], "/$id/") !== false) {
                return true;
            }
        }

        return false;
    }
}
