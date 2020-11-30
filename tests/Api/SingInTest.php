<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;
use Illuminate\Support\Str;

class SignInTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function user_should_be_signed_in()
    {
        $this->makeTestOauthClient();

        $password = Str::random(8);
        $user = User::factory()->create([
            'password' => Hash::make($password)
        ]);

        $this->json('post', 'api/signin', [
            'email' => $user->email,
            'password' => $password
        ])->assertJsonStructure([
            'token_type', 'expires_in', 'access_token', 'refresh_token'
        ])->assertStatus(200);
    }

    /** @test */
    public function should_sign_up_and_then_sign_in()
    {
        $this->makeTestOauthClient();

        $password = Str::random(8);
        $email = User::factory()->make()->email;

        $this->json('post', 'api/signup', [
            'email' => $email,
            'password' => $password
        ])->assertStatus(201);

        $this->json('post', 'api/signin', [
            'email' => $email,
            'password' => $password
        ])->assertStatus(200);
    }

    private function makeTestOauthClient(): void
    {
        DB::table('oauth_clients')->insert([
            'id' => 1,
            'user_id' => null,
            'name' => "api",
            'secret' => config('auth.passport.client_secret'),
            'redirect' => "http://localhost",
            'personal_access_client' => 0,
            'password_client' => config('auth.passport.client_id'),
            'revoked' => 0,
        ]);
    }
}
