<?php

namespace App\Contracts;

interface HeroAuthorizationContract
{
    public function hasVehicle($hero, $vehicleId): bool;
    public function hasSpecies($hero, $speciesId): bool;
    public function hasStarShip($hero, $starShipId): bool;
    public function hasPlanet($hero, $starShipId): bool;
}
