<?php

namespace App\Console\Commands;

use App\Contracts\SwapiApiContract;
use Illuminate\Console\Command;

class SwapiFilm extends Command
{

    protected $signature = 'swapi:film
                            { id : ID of film }';

    protected $description = 'Fetch film by id';

    private SwapiApiContract $api;

    public function __construct(SwapiApiContract $api)
    {
        parent::__construct();

        $this->api = $api;
    }

    public function handle()
    {
        $response = $this->api->fetchFilmById($this->argument('id'));

        $content = $response->getBody()->getContents();
        $result = json_decode($content);

        dump($result);

        return 0;
    }
}
