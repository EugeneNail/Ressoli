<?php

namespace App\Http\Requests;

use App\Actions\GetOptions;
use App\Models\House;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateHouseRequest extends FormRequest {
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
        $options = app()->make(GetOptions::class)->run(House::class);

        return [
            "water" => ["required", "string", Rule::in($options["water"])],
            "gas" => ["required", "string", Rule::in($options["gas"])],
            "electricity" => ["required", "string", Rule::in($options["electricity"])],
            "sewer" => ["required", "string", Rule::in($options["sewer"])],
            "walls" => ["required", "string", Rule::in($options["walls"])],
            "condition" => ["required", "string", Rule::in($options["condition"])],
            "roof" => ["required", "string", Rule::in($options["roof"])],
            "floor" => ["required", "string", Rule::in($options["floor"])],
            "level_count" => ["required", "numeric", "integer", "gt:0", "lte:100"],
            "has_garage" => ["required", "boolean"],
            "hot_water" => ["required", "string", Rule::in($options["hot_water"])],
            "heating" => ["required", "string", Rule::in($options["heating"])],
            "bath" => ["required", "string", Rule::in($options["bath"])],
            "bathroom" => ["required", "string", Rule::in($options["bathroom"])],
            "room_count" => ["required", "numeric", "integer", "gt:0", "lte:100"],
            "area" => ["required", "numeric", "integer", "gt:0", "lte:10000"],
            "kitchen_area" => ["required", "numeric", "integer", "gt:0", "lte:10000", "lte:area"],
            "land_area" => ["required", "numeric", "integer", "gt:0", "lte:10000"],
        ];
    }

    public function prepareForValidation() {
        $this->merge([
            "has_garage" => $this->input("has_garage") ?? false
        ]);
    }
}
