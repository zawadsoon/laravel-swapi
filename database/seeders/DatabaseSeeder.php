<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run()
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

        DB::table('users')->insert([
            'name' => null,
            'email' => "marcin@swapi.com",
            'email_verified_at' => null,
            'hero_id' => 1,
            'password' => Hash::make('password')
        ]);
    }
}
