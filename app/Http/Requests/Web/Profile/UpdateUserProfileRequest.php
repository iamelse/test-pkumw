<?php

namespace App\Http\Requests\Web\Profile;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUserProfileRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name'      => ['required', 'string', 'max:255'],
            'username'  => ['nullable', 'string', 'max:255', 'unique:users,username,' . $this->user()->id],
            'email'     => ['required', 'email', 'regex:/^[\w\.-]+@pkuwsb\.id$/', 'unique:users,email,' . $this->user()->id],
            'photo'     => ['nullable', 'image', 'max:2048'], // max 2MB
            'password'  => ['nullable', 'confirmed', 'min:8'],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required'      => 'Name is required.',
            'email.required'     => 'Email is required.',
            'email.regex'        => 'Email must use @pkuwsb.id domain.',
            'email.unique'       => 'This email is already taken.',
            'username.unique'    => 'This username is already taken.',
            'photo.image'        => 'Profile photo must be an image.',
            'photo.max'          => 'Profile photo cannot be larger than 2MB.',
            'password.confirmed' => 'Password confirmation does not match.',
            'password.min'       => 'Password must be at least 8 characters.',
        ];
    }
}
