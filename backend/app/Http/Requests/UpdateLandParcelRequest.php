<?php

namespace App\Http\Requests;

use App\Actions\GetOptions;
use App\Models\LandParcel;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateLandParcelRequest extends FormRequest {
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
        $options = (new GetOptions())->run(LandParcel::class);

        return [
            "gas" => ["required", "string", Rule::in($options["gas"])],
            "electricity" => ["required", "string", Rule::in($options["electricity"])],
            "water" => ["required", "string", Rule::in($options["water"])],
            "sewer" => ["required", "string", Rule::in($options["sewer"])],
            "area" => ["required", "numeric", "gt:0", "lte:10000"]
        ];
    }
}
