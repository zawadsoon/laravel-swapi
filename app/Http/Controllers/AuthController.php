<?php

namespace App\Http\Controllers;

use App\Events\UserCreated;
use App\Http\Requests\SignInRequest;
use App\Http\Requests\SignUpRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Laravel\Passport\Http\Controllers\AccessTokenController;

class AuthController extends Controller
{
    private AccessTokenController $accessTokenController;

    public function __construct(AccessTokenController $accessTokenController)
    {
        $this->accessTokenController = $accessTokenController;
    }

    public function signup(SignUpRequest $request): int
    {
        $user = new User();

        $user->email = $request->email;
        $user->password = Hash::make($request->password);

        $user->save();

        Log::info('UserCreated', $user->toArray());

        event(new UserCreated($user));

        return 201;
    }

    public function signin(SignInRequest $request)
    {
        $request = Request::create('oauth/token', 'POST', [
            'grant_type' => 'password',
            'client_id' => config('auth.passport.client_id'),
            'client_secret' => config('auth.passport.client_secret'),
            'username' => $request->email,
            'password' => $request->password,
            'scope' => '',
        ]);

        return app()->handle($request);
    }
}
