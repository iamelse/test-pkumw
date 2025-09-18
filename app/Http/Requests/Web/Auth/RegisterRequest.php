<?php

namespace App\Http\Requests\Web\Auth;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                'email',
                'regex:/^[a-zA-Z0-9._%+-]+@pkuwsb\.id$/',
                'unique:users,email'
            ],
            'password' => [
                'required',
                'string',
                'min:7',
                'regex:/[A-Z]/', // huruf kapital
                'regex:/[a-z]/', // huruf kecil
                'regex:/[0-9]/', // angka
                'confirmed',     // butuh password_confirmation di form
            ],
            'photo' => ['nullable', 'image', 'max:2048'],
        ];
    }

    public function messages(): array
    {
        return [
            'email.regex' => 'Email must use the @pkuwsb.id domain.',
            'password.regex' => 'Password must contain at least one uppercase letter, one lowercase letter, and one number.',
        ];
    }
}