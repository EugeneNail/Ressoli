<?php

namespace App\Http\Requests;

use App\Actions\ConvertKeysCase;
use App\Http\Responses\ApiResponse;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Validation\ValidationException;

class StoreClientRequest extends FormRequest {

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array {
        return [
            "name" => ["required", "string", "alpha", "min:3", "max:16"],
            "last_name" => ["required", "string", "alpha", "min:3", "max:16"],
            "phone_number" => ["required", "string", "regex:/^[+]?[0-9]-[0-9]{3}-[0-9]{3}-[0-9]{4}$/"],
        ];
    }
}
