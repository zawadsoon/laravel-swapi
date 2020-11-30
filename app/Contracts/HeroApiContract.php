<?php

namespace App\Contracts;

interface HeroApiContract
{
    public function getPersonById($id);
    public function getSpeciesById($id);
    public function getVehicleById($id);
    public function getStarShipsById($id);
    public function getPlanetsById($id);
    public function getFilmById($id);
}
