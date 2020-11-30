<?php

namespace App\Contracts;

use Psr\Http\Message\ResponseInterface;

interface SwapiApiContract
{
    public function fetchAllPeople($page = null): ResponseInterface;
    public function fetchPersonById($id): ResponseInterface;
    public function fetchSpeciesById($id): ResponseInterface;
    public function fetchVehicleById($id): ResponseInterface;
    public function fetchStarShipById($id): ResponseInterface;
    public function fetchPlanetById($id): ResponseInterface;
    public function fetchFilmById($id): ResponseInterface;
}
