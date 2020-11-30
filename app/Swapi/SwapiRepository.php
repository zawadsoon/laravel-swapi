<?php

namespace App\Swapi;

use App\Contracts\SwapiApiContract;
use App\Contracts\SwapiCacheContract;
use App\Contracts\SwapiRepositoryContract;
use App\Exceptions\SwapiCacheExpiredException;
use Illuminate\Support\Str;

class SwapiRepository implements SwapiRepositoryContract
{
    private SwapiCacheContract $cache;
    private SwapiApiContract $api;

    public function __construct(SwapiCacheContract $cache, SwapiApiContract $api)
    {
        $this->cache = $cache;
        $this->api = $api;
    }

    public function getRandomHeroId()
    {
        $cacheKey = 'people/?page=1';
        $content = null;

        try {
            $content = $this->cache->get($cacheKey);
        } catch (SwapiCacheExpiredException $e) {
            $content = null;
        }

        if (!$content) {
            $response = $this->api->fetchAllPeople();
            $content = $response->getBody()->getContents();
            $this->cache->set($cacheKey, $content);
        }

        $result = json_decode($content);

        /**
         * Very naive implementation
         * We are never sure that entry actually exists
         */
        return rand(1, $result->count);
    }

    public function getPersonById($id)
    {
        return $this->getSubjectById('person', $id);
    }

    public function getSpeciesById($id)
    {
        return $this->getSubjectById('species', $id);
    }

    public function getVehicleById($id)
    {
        return $this->getSubjectById('vehicle', $id);
    }

    public function getStarShipById($id)
    {
        return $this->getSubjectById('star_ship', $id);
    }

    public function getPlanetById($id)
    {
        return $this->getSubjectById('planet', $id);
    }

    public function getFilmById($id)
    {
        return $this->getSubjectById('film', $id);
    }

    public function getSubjectById($subject, $id)
    {
        $cacheKey = Str::lower($subject) . '/' . $id;
        $apiFuncName = 'fetch' . Str::studly($subject) . 'ById';
        $content = null;

        try {
            $content = $this->cache->get($cacheKey);
        } catch (SwapiCacheExpiredException $e) {
            $content =  null;
        }

        if (!$content) {
            $response = $this->api->{$apiFuncName}($id);
            $content = $response->getBody()->getContents();
            $this->cache->set($cacheKey, $content);
        }

        return json_decode($content);
    }
}
