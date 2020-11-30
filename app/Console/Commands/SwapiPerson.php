<?php

namespace App\Console\Commands;

use App\Contracts\SwapiApiContract;
use Illuminate\Console\Command;

class SwapiPerson extends Command
{
    protected $signature = 'swapi:person
                            { id : ID of person }';

    protected $description = 'Fetch person by id';

    private SwapiApiContract $api;

    public function __construct(SwapiApiContract $api)
    {
        parent::__construct();

        $this->api = $api;
    }

    public function handle()
    {
        $response = $this->api->fetchPersonById($this->argument('id'));

        $content = $response->getBody()->getContents();
        $result = json_decode($content);

        dump($result);

        return 0;
    }
}
