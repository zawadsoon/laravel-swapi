<?php

namespace App\Swapi;

use App\Contracts\SwapiApiContract;
use GuzzleHttp\Client;
use Psr\Http\Message\ResponseInterface;

/**
 * @see https://swapi.dev/documentation
 */
class SwapiApi implements SwapiApiContract
{
    private Client $httpClient;

    public function __construct(Client $httpClient)
    {
        $this->httpClient = $httpClient;
    }

    public function fetchAllPeople($page = null): ResponseInterface
    {
        $path = "api/people/";

        if (!is_null($page)) {
            $path .= "?page=$page";
        }

        return $this->httpClient->request('GET', $path);
    }

    public function fetchPersonById($id): ResponseInterface
    {
        return $this->httpClient->request('GET', "api/people/{$id}/");
    }

    public function fetchSpeciesById($id): ResponseInterface
    {
        return $this->httpClient->request('GET', "api/species/{$id}/");
    }

    public function fetchVehicleById($id): ResponseInterface
    {
        return $this->httpClient->request('GET', "api/vehicles/{$id}/");
    }

    public function fetchStarShipById($id): ResponseInterface
    {
        return $this->httpClient->request('GET', "api/starships/{$id}/");
    }

    public function fetchPlanetsById($id): ResponseInterface
    {
        return $this->httpClient->request('GET', "api/planets/{$id}/");
    }

    public function fetchFilmById($id): ResponseInterface
    {
        return $this->httpClient->request('GET', "api/films/{$id}/");
    }
}
