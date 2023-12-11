<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

// slash space alpha numeric dash
class Ssand implements ValidationRule {
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void {
        if (!$this->isValid($value)) {
            $fail(__("validation.ssand"));
        }
    }

    public function isValid(mixed $value): bool {
        $pattern = '/[^a-zA-Z0-9 \/-]/';
        return !preg_match($pattern, $value);
    }
}
