<?php

namespace App\Http\Controllers;

use App\Contracts\SwapiAuthorizationContract;
use App\Contracts\SwapiRepositoryContract;
use App\Models\User;

class FilmController extends Controller
{
    private SwapiRepositoryContract $repository;
    private SwapiAuthorizationContract $auth;

    public function __construct(SwapiRepositoryContract $repository, SwapiAuthorizationContract $auth)
    {
        $this->repository = $repository;
        $this->auth = $auth;
    }

    public function getFilmsAssociatedWithCurrentUser()
    {
        // TODO Should check if user has hero
        $user = User::find(auth()->id());
        $hero = $this->repository->getPersonById($user->hero_id);

        // TODO Probably should load all films? 
        return response()->json($hero->films);
    }

    public function getFilmById($id)
    {
        $user = User::find(auth()->id());
        $hero = $this->repository->getPersonById($user->hero_id);

        if (!$this->auth->hasFilm($hero, $id)) {
            abort(404, 'Film not found');
        }

        return response()->json(
            $this->repository->getFilmById($id)
        );
    }
}
