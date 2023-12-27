<?php

namespace App\Http\Requests;

use App\Actions\GetOptions;
use App\Models\Application;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Response;
use Illuminate\Validation\Rule;
use Illuminate\Support\Str;

class StoreApplicationRequest extends FormRequest {

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
        $options = app()->make(GetOptions::class)->run(Application::class);
        return [
            "client_id" => ["required", "numeric", "integer", "exists:clients,id"],
            "address_id" => ["required", "numeric", "integer", "exists:addresses,id"],
            "applicable_id" => ["required", "numeric", "integer", $this->getApplicableRule()],
            "price" => ["required", "numeric", "integer", "gt:0", "lte:10000000"],
            "contract" => ["required", "string", Rule::in($options["contract"])],
            "has_mortgage" => ["required", "boolean"],
        ];
    }

    private function getApplicableRule(): string {
        $allowedApplicables = [
            "land-parcels",
            "houses",
            "apartments"
        ];
        $applicables = $this->route("applicables");

        if (!in_array($applicables, $allowedApplicables)) {
            abort(Response::HTTP_NOT_FOUND, "Invalid applicable type");
        }

        //Str::snake() won't work because it can't convert kebab case strings
        return "exists:" . str_replace("-", "_", $applicables) . ",id";
    }

    public function prepareForValidation() {
        $this->merge([
            "has_mortgage" => $this->input("has_mortgage") ?? false
        ]);
    }
}
