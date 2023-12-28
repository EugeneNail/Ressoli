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
            "has_water" => ["required", "boolean"],
            "has_gas" => ["required", "boolean"],
            "has_electricity" => ["required", "boolean"],
            "has_sewer" => ["required", "boolean"],
            "condition" => ["required", "string", Rule::in($options["condition"])],
            "walls" => ["required", "string", Rule::in($options["walls"])],
            "ceiling" => ["required", "numeric", "gt:1.5", "lte:5"],
            "level" => ["required", "numeric", "gt:0", "integer", "lte:100", "lte:level_count"],
            "level_count" => ["required", "numeric", "gt:0", "integer", "lte:100"],
            "has_heating" => ["required", "boolean"],
            "has_hot_water" => ["required", "boolean"],
            "bath" => ["required", "string", Rule::in($options["bath"])],
            "bathroom" => ["required", "string", Rule::in($options["bathroom"])],
            "area" => ["required", "numeric", "gt:0", "integer", "lte:10000"],
            "room_count" => ["required", "numeric", "gt:0", "integer", "lte:100"],
            "has_loggia" => ["required", "boolean"],
            "has_balcony" => ["required", "boolean"],
            "has_garage" => ["required", "boolean"],
            "has_garbage_chute" => ["required", "boolean"],
            "has_elevator" => ["required", "boolean"],
            "is_corner" => ["required", "boolean"],
        ];
    }

    public function prepareForValidation() {
        $this->merge([
            "has_water" => $this->input("has_water") ?? false,
            "has_gas" => $this->input("has_gas") ?? false,
            "has_electricity" => $this->input("has_electricity") ?? false,
            "has_sewer" => $this->input("has_sewer") ?? false,
            "has_heating" => $this->input("has_heating") ?? false,
            "has_hot_water" => $this->input("has_hot_water") ?? false,
            "has_loggia" => $this->input("has_loggia") ?? false,
            "has_balcony" => $this->input("has_balcony") ?? false,
            "has_garage" => $this->input("has_garage") ?? false,
            "has_garbage_chute" => $this->input("has_garbage_chute") ?? false,
            "has_elevator" => $this->input("has_elevator") ?? false,
            "is_corner" => $this->input("is_corner") ?? false,
        ]);
    }
}
