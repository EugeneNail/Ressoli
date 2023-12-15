<?php

namespace Tests\Unit;

use Illuminate\Support\Facades\Validator;
use Tests\TestCase;

class RequestValidationTest extends TestCase {

    protected array $rules;

    public function setUp(): void {
        parent::setUp();
    }

    protected function validateField(string $field, mixed $value) {
        return Validator::make(
            [$field => $value],
            [$field => $this->rules[$field]]
        )->passes();
    }
}
