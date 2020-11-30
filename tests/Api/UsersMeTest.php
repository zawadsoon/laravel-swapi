<?php

namespace Api;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UsersMeTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function should_update_email()
    {

        $newEmail = User::factory()->make()->email;
        $user = User::factory()->create();
        $this->asUser($user);

        $this->assertDatabaseHas('users', ['email' => $user->email]);

        $this
            ->json('put', 'api/users/me', ['email' => $newEmail])
            ->assertStatus(200);

        $this->assertDatabaseMissing('users', ['email' => $user->email]);
        $this->assertDatabaseHas('users', ['email' => $newEmail]);
        $this->assertDatabaseCount('users', 1);
    }

    public function test401(): void
    {
        $this
            ->json('put', 'api/users/me', ['email' => 'foo-bar'])
            ->assertStatus(401);
    }
}
