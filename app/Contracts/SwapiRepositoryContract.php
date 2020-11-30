<?php

namespace App\Contracts;

interface SwapiRepositoryContract
{
    public function getRandomHeroId();
    public function getPersonById($id);
    public function getSpeciesById($id);
    public function getVehicleById($id);
    public function getStarShipById($id);
    public function getPlanetById($id);
    public function getFilmById($id);
}
