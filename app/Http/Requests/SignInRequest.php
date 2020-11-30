<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Hash;

class SignInRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $email = $this->email;

        return [
            'email' => 'bail|exists:\App\Models\User,email',
            'password' => function ($attribute, $value, $fail) use ($email) {
                $user = User::where('email', $email)->first();

                if ($user && Hash::check($value, $user->password)) {
                    return;
                }

                $fail(__('auth.failed'));
            }
        ];
    }
}
