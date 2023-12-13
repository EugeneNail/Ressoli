<?php

namespace App\Http\Requests;

use App\Actions\GetOptions;
use App\Models\Address;
use App\Rules\Ssand;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreAddressRequest extends FormRequest {
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
    public function rules(GetOptions $getOptions): array {
        $types_of_street = $getOptions->run(Address::class)["type_of_street"];

        return [
            "number" => ["required", "string", "ssand", "max:8"],
            "unit" => ["nullable", "string", "ssand", "max:8"],
            "street" => ["required", "string", "ssand", "max:32"],
            "type_of_street" => ["required", "string", Rule::in($types_of_street)],
            "city" => ["required", "string", "ssand", "max:32"],
            "postal_code" => ["nullable", "string", "ssand", "max:16"],
        ];
    }

    public function prepareForValidation() {
        $this->merge([
            "unit" => $this->has("unit") ? $this->unit : null,
            "postal_code" => $this->has("postal_code") ? $this->postal_code : null,
        ]);
    }
}
