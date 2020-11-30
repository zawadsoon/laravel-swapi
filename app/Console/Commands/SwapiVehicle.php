<?php

namespace App\Console\Commands;

use App\Contracts\SwapiApiContract;
use Illuminate\Console\Command;

class SwapiVehicle extends Command
{
    protected $signature = 'swapi:vehicle
                            { id : ID of vehicle }';

    protected $description = 'Fetch vehicle by id';

    private SwapiApiContract $api;

    public function __construct(SwapiApiContract $api)
    {
        parent::__construct();

        $this->api = $api;
    }

    public function handle()
    {
        $response = $this->api->fetchVehicleById($this->argument('id'));

        $content = $response->getBody()->getContents();
        $result = json_decode($content);

        dump($result);

        return 0;
    }
}
