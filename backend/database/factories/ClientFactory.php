<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Client>
 */
class ClientFactory extends Factory {
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array {
        return [
            "name" => fake()->firstName(),
            "last_name" => fake()->lastName(),
            "phone_number" => fake()->numerify("#-###-###-####")
        ];
    }

    public function test(): static {
        return $this->state(fn () => [
            "name" => "John",
            "last_name" => "Doe",
            "phone_number" => "1-234-567-8900"
        ]);
    }
}
