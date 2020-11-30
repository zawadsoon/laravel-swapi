<?php

namespace App\Contracts;

interface SwapiAuthorizationContract
{
    public function hasVehicle($hero, $vehicleId): bool;
    public function hasSpecies($hero, $speciesId): bool;
    public function hasStarShip($hero, $starShipId): bool;
    public function hasPlanet($hero, $planetId): bool;
    public function hasFilm($hero, $filmId): bool;
}
