<?php

namespace App\Http\Controllers;

use App\Contracts\SwapiAuthorizationContract;
use App\Contracts\SwapiRepositoryContract;
use App\Models\User;
use Illuminate\Http\Request;

class VehicleController extends Controller
{
    private SwapiRepositoryContract $repository;
    private SwapiAuthorizationContract $auth;

    public function __construct(SwapiRepositoryContract $repository, SwapiAuthorizationContract $auth)
    {
        $this->repository = $repository;
        $this->auth = $auth;
    }

    public function getVehiclesAssociatedWithCurrentUser()
    {
        $user = User::find(auth()->id());
        $hero = $this->repository->getPersonById($user->hero_id);
        return response()->json($hero->vehicles);
    }

    public function getVehicleById($id)
    {
        $user = User::find(auth()->id());
        $hero = $this->repository->getPersonById($user->hero_id);

        if (!$this->auth->hasVehicle($hero, $id)) {
            abort(404, 'Vehicle not found');
        }

        return response()->json(
            $this->repository->getVehicleById($id)
        );
    }
}
