<?php

namespace App\Contracts;

interface SwapiAuthorizationContract
{
    public function hasVehicle($Swapi, $vehicleId): bool;
    public function hasSpecies($Swapi, $speciesId): bool;
    public function hasStarShip($Swapi, $starShipId): bool;
    public function hasPlanet($Swapi, $starShipId): bool;
    public function hasFilm($Swapi, $filmId): bool;
}
