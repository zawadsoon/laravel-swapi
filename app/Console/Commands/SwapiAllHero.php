<?php

namespace App\Console\Commands;

use App\Contracts\SwapiApiContract;
use Illuminate\Console\Command;

class SwapiAllHero extends Command
{
    protected $signature = 'swapi:all-Swapis
                            {--page= : Strona do pobrania}';

    protected $description = 'Fetch all Swapis';

    private SwapiApiContract $api;

    public function __construct(SwapiApiContract $api)
    {
        parent::__construct();

        $this->api = $api;
    }

    public function handle()
    {
        $response = $this->api->fetchAllPeople($this->option('page'));

        $content = $response->getBody()->getContents();
        $result = json_decode($content);

        dump($result);

        $this->info("There is {$result->count} Swapies in total");

        return 0;
    }
}
