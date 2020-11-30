<?php

namespace App\Http\Controllers;

use App\Events\UserCreated;
use App\Http\Requests\SignUpRequest;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class AuthController extends Controller
{
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
}
