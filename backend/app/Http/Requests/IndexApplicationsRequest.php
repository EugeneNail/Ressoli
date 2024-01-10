<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class IndexApplicationsRequest extends FormRequest {
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
            "types" => ["nullable", "array", Rule::in(["houses", "apartments", "land-parcels"])],
            "page" => ["integer", "gt:0"],
            "owned" => ["nullable", "string", Rule::in(["true", "false"])],
            "statuses" => ["nullable", "array", Rule::in(["active", "archived"])],
            "min-price" => ["nullable", "integer", "min:0", "max:10000000"],
            "max-price" => ["nullable", "integer", "min:0", "max:10000000"],
            "min-area" => ["nullable", "integer", "min:0", "max:10000"],
            "max-area" => ["nullable", "integer", "min:0", "max:10000"],
            "contracts" => ["nullable", "array", Rule::in(["Sale", "Rent"])],
            "min-date" => ["nullable", "string", "regex:/^20[0-9]{2}-(0[1-9]|1[0-2])-(0[1-9]|[1-2]\d|3[0-1])$/"],
            "max-date" => ["nullable", "string", "regex:/^20[0-9]{2}-(0[1-9]|1[0-2])-(0[1-9]|[1-2]\d|3[0-1])$/"],
            "no-photos" => ["nullable", "string", Rule::in(["true", "false"])],
        ];
    }
}
