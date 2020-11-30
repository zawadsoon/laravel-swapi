<?php

namespace Tests;

use App\Models\User;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Laravel\Passport\Passport;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    protected function asUser(?User $user = null): User
    {
        return tap($user ?? User::factory()->create(), function ($user) {
            Passport::actingAs($user);
        });
    }
}
