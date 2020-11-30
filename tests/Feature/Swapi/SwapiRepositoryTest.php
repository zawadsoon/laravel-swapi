<?php

namespace Feature\Swapi;

use App\Contracts\SwapiCacheContract;
use App\Swapi\SwapiApi;
use App\Swapi\SwapiRepository;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Response;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\File;
use Tests\TestCase;

class SwapiRepositoryTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function getRandomHero_should_return_random_hero_id()
    {
        $httpMock = $this->getHttpClientMock($this->getAllPeopleResponseContent());

        $repo = new SwapiRepository(
            app()->make(SwapiCacheContract::class),
            new SwapiApi($httpMock)
        );

        $id = $repo->getRandomHeroId();
        $this->assertIsInt($id);
        $this->assertTrue($id > 0);
        $this->assertTrue($id < 83);
    }

    /** @test */
    public function getPersonById_should_get_person()
    {
        $httpMock = $this->getHttpClientMock($this->getPeople1Response());

        $repo = new SwapiRepository(
            app()->make(SwapiCacheContract::class),
            new SwapiApi($httpMock)
        );

        $person = $repo->getPersonById(1);
        $this->assertEquals('Luke Skywalker', $person->name);
    }

    private function getAllPeopleResponseContent()
    {
        return File::get(resource_path('responses/people.json'));
    }

    private function getPeople1Response()
    {
        return File::get(resource_path('responses/people-1.json'));
    }

    private function getHttpClientMock($expectedResponse): Client
    {
        $clientMock = $this->getMockBuilder(Client::class)->getMock();
        $clientMock
            ->expects($this->once())
            ->method('request')
            ->will($this->returnValue(new Response(200, [], $expectedResponse)));

        return $clientMock;
    }
}
