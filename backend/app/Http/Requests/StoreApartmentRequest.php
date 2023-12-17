<?php

namespace App\Http\Requests;

use App\Actions\GetOptions;
use App\Models\Apartment;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreApartmentRequest extends FormRequest {
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
        $options = app()->make(GetOptions::class)->run(Apartment::class);

        return [
            "has_water" => ["nullable", "boolean"],
            "has_gas" => ["nullable", "boolean"],
            "has_electricity" => ["nullable", "boolean"],
            "has_sewer" => ["nullable", "boolean"],
            "condition" => ["required", "string", Rule::in($options["condition"])],
            "walls" => ["required", "string", Rule::in($options["walls"])],
            "ceiling" => ["required", "numeric", "gt:1.5", "lte:5"],
            "level" => ["required", "numeric", "gt:0", "integer", "lte:100", "lte:level_count"],
            "level_count" => ["required", "numeric", "gt:0", "integer", "lte:100"],
            "has_heating" => ["nullable", "boolean"],
            "has_hot_water" => ["nullable", "boolean"],
            "bath" => ["required", "string", Rule::in($options["bath"])],
            "bathroom" => ["required", "string", Rule::in($options["bathroom"])],
            "area" => ["required", "numeric", "gt:0", "integer", "lte:10000"],
            "room_count" => ["required", "numeric", "gt:0", "integer", "lte:100"],
            "has_loggia" => ["nullable", "boolean"],
            "has_balcony" => ["nullable", "boolean"],
            "has_garage" => ["nullable", "boolean"],
            "has_garbage_chute" => ["nullable", "boolean"],
            "has_elevator" => ["nullable", "boolean"],
            "is_corner" => ["nullable", "boolean"],
        ];
    }
}
