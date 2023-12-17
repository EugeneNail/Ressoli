<?php

namespace Tests\Unit;

use Illuminate\Support\Facades\Validator;
use Tests\TestCase;

class RequestValidationTest extends TestCase {

    protected array $rules;

    public function setUp(): void {
        parent::setUp();
    }

    protected function validateField(string $field, mixed $value): bool {
        return Validator::make(
            [$field => $value],
            [$field => $this->rules[$field]]
        )->passes();
    }


    /**
     * Validates multiple fields. Applies when validation rules for multiple fields are referenced from each other
     * @param ...$fields Sequence of [string, mixed] tuples
     * @return bool
     */
    protected function validateMultipleFields(...$fields): bool {
        $data = [];
        $rules = [];


        dump($data);
        dump($rules);
        foreach ($fields as $tuple) {

            if (!is_array($tuple) || count($tuple) !== 2) {
                throw new \InvalidArgumentException("The parameter must be a [string, mixed] tuple.");
            }
            $data[$tuple[0]] = $tuple[1];
            $rules[$tuple[0]] = $this->rules[$tuple[0]];
        }

        return Validator::make($data, $rules)->passes();
    }
}
