<?php

namespace App\Console\Commands;

use App\Contracts\SwapiApiContract;
use Illuminate\Console\Command;

class SwapiStarShip extends Command
{
    protected $signature = 'swapi:starship
                            { id : ID of starship }';

    protected $description = 'Fetch starship by id';

    private SwapiApiContract $api;

    public function __construct(SwapiApiContract $api)
    {
        parent::__construct();

        $this->api = $api;
    }

    public function handle()
    {
        $response = $this->api->fetchStarShipById($this->argument('id'));

        $content = $response->getBody()->getContents();
        $result = json_decode($content);

        dump($result);

        return 0;
    }
}
