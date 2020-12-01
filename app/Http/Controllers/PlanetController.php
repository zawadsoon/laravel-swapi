<?php

namespace App\Http\Controllers;

use App\Contracts\SwapiAuthorizationContract;
use App\Contracts\SwapiRepositoryContract;
use App\Models\User;
use Illuminate\Http\Request;

class PlanetController extends Controller
{
    private SwapiRepositoryContract $repository;
    private SwapiAuthorizationContract $auth;

    public function __construct(SwapiRepositoryContract $repository, SwapiAuthorizationContract $auth)
    {
        $this->repository = $repository;
        $this->auth = $auth;
    }

    public function getPlanetsAssociatedWithCurrentUser()
    {
        $user = User::find(auth()->id());
        $hero = $this->repository->getPersonById($user->hero_id);
        return response()->json([$hero->homeworld]);
    }

    public function getPlanetById($id)
    {
        $user = User::find(auth()->id());
        $hero = $this->repository->getPersonById($user->hero_id);

        if (!$this->auth->hasPlanet($hero, $id)) {
            abort(404, 'Planet not found');
        }

        return response()->json(
            $this->repository->getPlanetById($id)
        );
    }
}
