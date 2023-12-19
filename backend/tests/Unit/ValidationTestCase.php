<?php

namespace Tests\Unit;

use Illuminate\Support\Facades\Validator;
use Tests\TestCase;

class ValidationTestCase extends TestCase {

    protected array $rules;

    public function setUp(): void {
        parent::setUp();
    }

    /**
     * Validates one field or multiple fields.
     * Can be applied when validation rules for multiple fields are referenced from each other
     * @param ...$tuples Sequence of [string $field, mixed $value] tuples
     * @return bool
     */
    protected function validate(...$tuples): bool {
        $data = [];
        $rules = [];

        foreach ($tuples as $tuple) {

            if (!is_array($tuple) || count($tuple) !== 2 || gettype($tuple[0]) != "string") {
                throw new \InvalidArgumentException("The parameter must be a [string, mixed] tuple.");
            }

            [$field, $value] = $tuple;
            $data[$field] = $value;
            $rules[$field] = $this->rules[$field];
        }

        return Validator::make($data, $rules)->passes();
    }
}
