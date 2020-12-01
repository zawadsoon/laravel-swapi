<?php

namespace App\Http\Controllers;

use App\Contracts\SwapiAuthorizationContract;
use App\Contracts\SwapiRepositoryContract;
use App\Models\User;
use Illuminate\Http\Request;

class StarShipController extends Controller
{
    private SwapiRepositoryContract $repository;
    private SwapiAuthorizationContract $auth;

    public function __construct(SwapiRepositoryContract $repository, SwapiAuthorizationContract $auth)
    {
        $this->repository = $repository;
        $this->auth = $auth;
    }

    public function getStarShipsAssociatedWithCurrentUser()
    {
        $user = User::find(auth()->id());
        $hero = $this->repository->getPersonById($user->hero_id);
        return response()->json($hero->starships);
    }

    public function getStarShipById($id)
    {
        $user = User::find(auth()->id());
        $hero = $this->repository->getPersonById($user->hero_id);

        if (!$this->auth->hasStarship($hero, $id)) {
            abort(404, 'Starship not found');
        }

        return response()->json(
            $this->repository->getStarShipById($id)
        );
    }
}
