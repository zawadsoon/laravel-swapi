<?php

namespace Tests\Feature;

use App\Events\UserCreated;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;
use Illuminate\Support\Str;


class SignUpTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function should_create_user()
    {
        Event::fake();

        $password = Str::random(8);
        $email = User::factory()->make()->email;

        $this->json('post', 'api/signup', [
            'email' => $email,
            'password' => $password
        ])->assertStatus(201);

        $this->assertDatabaseHas('users', ['email' => $email]);

        $user = User::where('email', $email)->first();

        $this->assertNotNull($user);
        $this->assertTrue(Hash::check($password, $user->password));

        Event::assertDispatched(UserCreated::class);
    }
}
