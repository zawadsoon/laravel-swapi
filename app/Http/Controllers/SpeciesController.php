<?php

namespace App\Http\Controllers;

use App\Contracts\SwapiAuthorizationContract;
use App\Contracts\SwapiRepositoryContract;
use App\Models\User;

class SpeciesController extends Controller
{
    private SwapiRepositoryContract $repository;
    private SwapiAuthorizationContract $auth;

    public function __construct(SwapiRepositoryContract $repository, SwapiAuthorizationContract $auth)
    {
        $this->repository = $repository;
        $this->auth = $auth;
    }

    public function getSpeciesAssociatedWithCurrentUser()
    {
        $user = User::find(auth()->id());
        $hero = $this->repository->getPersonById($user->hero_id);
        return response()->json($hero->species);
    }

    public function getSpeciesById($id)
    {
        $user = User::find(auth()->id());
        $hero = $this->repository->getPersonById($user->hero_id);

        if (!$this->auth->hasSpecies($hero, $id)) {
            abort(404, 'Species not found');
        }

        return response()->json(
            $this->repository->getSpeciesById($id)
        );
    }
}
