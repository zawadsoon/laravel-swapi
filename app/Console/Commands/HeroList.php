<?php

namespace App\Console\Commands;

use App\Contracts\SwapiRepositoryContract;
use App\Models\User;
use Illuminate\Console\Command;

class HeroList extends Command
{
    protected $signature = 'hero:list';
    protected $description = 'Lists all users with assigned hero';

    private SwapiRepositoryContract $repository;

    public function __construct(SwapiRepositoryContract $repository)
    {
        parent::__construct();

        $this->repository = $repository;
    }

    public function handle()
    {
        User::all()->each(function ($user) {
            $hero = $this->repository->getPersonById($user->hero_id);
            $this->info($user->email . ' - ' . $hero->name);
        });

        return 0;
    }
}
