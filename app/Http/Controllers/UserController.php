<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserUpdateMeRequest;
use App\Models\User;

class UserController extends Controller
{
    public function updateMe(UserUpdateMeRequest $request)
    {
        $user = User::find(auth()->id());
        $user->email = $request->email;
        $user->save();
        return 200;
    }
}
