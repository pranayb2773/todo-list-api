<?php

namespace App\Http\Requests\v1;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

class CreateUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'min:3', 'max:255'],
            'email' => ['required', 'email', 'max:150', 'unique:users'],
            'password' => ['required', 'string', 'min:8', Password::min(8)->mixedCase()->numbers()->symbols()->uncompromised()],
            'password_confirmation' => ['required', 'string', 'same:password'],
            'is_admin' => ['nullable', 'bool']
        ];
    }
}
