<?php

namespace Database\Factories;

use App\Actions\GetOptions;
use App\Models\Address;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Address>
 */
class AddressFactory extends Factory {
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array {
        $typesOfStreet = app()->make(GetOptions::class)->run(Address::class)["type_of_street"];
        $unit = null;

        if (fake()->boolean(70)) {
            $unit = fake()->boolean() ? fake()->bothify("#?") : fake()->bothify("###-?");
        }

        return [
            "number" => fake()->randomNumber(3),
            "unit" => $unit,
            "street" => fake()->streetName(),
            "type_of_street" => $typesOfStreet[array_rand($typesOfStreet)],
            "city" => fake()->city(),
            "postal_code" => fake()->boolean() ? fake()->bothify("#####") : fake()->bothify("###-?"),
            "latitude" => fake()->randomFloat(7, 26, 44),
            "longitude" => fake()->randomFloat(7, -123, -80)
        ];
    }

    // The White House
    public function test(): static {
        return $this->state(fn () => [
            "number" => "1600",
            "unit" => "234b",
            "street" => "Pennsylvania",
            "type_of_street" => "Ave",
            "city" => "Washington",
            "postal_code" => "20500",
            "latitude" => 38.89768,
            "longitude" => -77.03655,
        ]);
    }

    public function withoutUnit(): static {
        return $this->state(fn () => ["unit" => null]);
    }
}
