<?php

namespace App\Console\Commands;

use App\Contracts\SwapiApiContract;
use Illuminate\Console\Command;

class SwapiSpecies extends Command
{
    protected $signature = 'swapi:species
                            { id : ID of species }';

    protected $description = 'Fetch species by id';

    public function __construct(SwapiApiContract $api)
    {
        parent::__construct();

        $this->api = $api;
    }

    public function handle()
    {
        $response = $this->api->fetchSpeciesById($this->argument('id'));

        $content = $response->getBody()->getContents();
        $result = json_decode($content);

        dump($result);

        return 0;
    }
}
