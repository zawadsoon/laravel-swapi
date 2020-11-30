<?php

namespace Feature\Swapi;

use App\Exceptions\SwapiCacheExpiredException;
use App\Models\SwapiCache;
use App\Swapi\SwapiCacheDBDriver;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SwapiCacheDBDriverTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function set_should_create_entry_if_not_exists()
    {
        $fakeEntry = SwapiCache::factory()->make();

        $this->assertDatabaseCount('swapi_cache', 0);

        $cache = new SwapiCacheDBDriver(0);
        $cache->set($fakeEntry->key, $fakeEntry->value);

        $this->assertDatabaseHas('swapi_cache', [
            'key' => $fakeEntry->key,
            'value' => $fakeEntry->value,
        ]);
    }

    /** @test */
    public function set_should_update_existing_entry()
    {
        $prevValue = SwapiCache::factory()->make()->value;
        $nextValue = SwapiCache::factory()->make()->value;

        $entry = SwapiCache::factory()->create([
            'value' => $prevValue
        ]);

        $this->assertDatabaseCount('swapi_cache', 1);
        $this->assertDatabaseHas('swapi_cache', [
            'key' => $entry->key,
            'value' => $prevValue
        ]);

        $cache = new SwapiCacheDBDriver(0);
        $cache->set($entry->key, $nextValue);

        $this->assertDatabaseCount('swapi_cache', 1);
        $this->assertDatabaseHas('swapi_cache', [
            'key' => $entry->key,
            'value' => $nextValue
        ]);
    }

    public function is_expired_should_return_false_if_entry_is_still_fresh()
    {
        $entry = SwapiCache::factory()->make(['cached_at' => now()->subHours(5)]);
        $cache = new SwapiCacheDBDriver(86400);
        $result = $cache->isExpired($entry);
        $this->assertFalse($result);
    }

    /** @test */
    public function is_expired_should_return_true_if_entry_exceeded_given_time()
    {
        $entry = SwapiCache::factory()->make(['cached_at' => now()->subHours(25)]);
        $cache = new SwapiCacheDBDriver(86400);
        $result = $cache->isExpired($entry);
        $this->assertTrue($result);
    }

    public function get_should_throw_exception_if_entry_is_stale()
    {
        $this->expectException(SwapiCacheExpiredException::class);
        $entry = SwapiCache::factory()->create(['cached_at' => now()->subDays(5)]);
        $cache = new SwapiCacheDBDriver(86400);
        $cache->get($entry->key);
    }

    /** @test */
    public function get_should_return_null_if_entry_do_not_exists()
    {
        $entry = SwapiCache::factory()->make(['cached_at' => now()]);
        $cache = new SwapiCacheDBDriver(86400);
        $value = $cache->get($entry->key);
        $this->assertNull($value);
    }

    /** @test */
    public function get_should_return_value()
    {
        $entry = SwapiCache::factory()->create(['cached_at' => now()]);
        $cache = new SwapiCacheDBDriver(86400);
        $value = $cache->get($entry->key);
        $this->assertEquals($entry->value, $value);
    }
}
