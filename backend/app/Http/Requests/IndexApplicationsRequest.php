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
            "status" => ["nullable", "string", Rule::in(["Active", "Archived"])],
            "start-price" => ["nullable", "integer", "min:0", "max:10000000"],
            "end-price" => ["nullable", "integer", "min:0", "max:10000000"],
            "start-area" => ["nullable", "integer", "min:0", "max:10000"],
            "end-area" => ["nullable", "integer", "min:0", "max:10000"],
            "contract" => ["nullable", "string", Rule::in(["Sale", "Rent"])],
            "start-date" => ["nullable", "string", "regex:/^20[0-9]{2}-(0[1-9]|1[0-2])-(0[1-9]|[1-2]\d|3[0-1])$/"],
            "end-date" => ["nullable", "string", "regex:/^20[0-9]{2}-(0[1-9]|1[0-2])-(0[1-9]|[1-2]\d|3[0-1])$/"],
            "no-photos" => ["nullable", "string", Rule::in(["true", "false"])],
        ];
    }
}
