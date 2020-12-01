<?php

namespace App\Listeners;

use App\Contracts\SwapiRepositoryContract;

class AttachRandomHeroToUser
{
    private SwapiRepositoryContract $swapiRepository;

    public function __construct(SwapiRepositoryContract $swapiRepository)
    {
        $this->swapiRepository = $swapiRepository;
    }

    public function handle($event): void
    {
        $user = $event->user;
        $user->hero_id = $this->swapiRepository->getRandomHeroId();
        $user->save();
    }
}
