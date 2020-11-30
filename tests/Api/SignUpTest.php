<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;
use Illuminate\Support\Str;


class SignUpTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function should_create_user()
    {
        $password = Str::random(8);
        $email = User::factory()->make()->email;

        $response = $this->json('get', 'api/signup', [
            'email' => $email,
            'password' => $password
        ]);

        $response->assertStatus(201);

        $this->assertDatabaseHas('users', ['email' => $email]);

        $user = User::where('email', $email)->first();

        $this->assertNotNull($user);
        $this->assertTrue(Hash::check($password, $user->password));
    }
}
