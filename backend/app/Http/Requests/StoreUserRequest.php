<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

class StoreUserRequest extends FormRequest {
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array {
        return [
            "name" => ["required", "string", "alpha", "min:3", "max:16"],
            "last_name" => ["required", "string", "alpha", "min:3", "max:16"],
            "email" => ["required", "string", "email"],
            "password" => ["required", "string", Password::min(8)->mixedCase()->numbers()->letters()],
            "password_confirmation" => ["required", "string", "same:password"],
        ];
    }
}
