<?php

namespace Database\Factories;

use App\Actions\GetOptions;
use App\Models\Apartment;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Apartment>
 */
class ApartmentFactory extends Factory {
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array {
        $options = app()->make(GetOptions::class)->run(Apartment::class);
        $randomOption = function (string $name) use ($options) {
            return $options[$name][array_rand($options[$name])];
        };

        return [
            "has_water" => fake()->boolean(60),
            "has_gas" => fake()->boolean(60),
            "has_electricity" => fake()->boolean(60),
            "has_sewer" => fake()->boolean(60),
            "condition" => $randomOption("condition"),
            "walls" => $randomOption("walls"),
            "ceiling" => fake()->randomFloat(2, 1.5, 5),
            "level" => fake()->randomNumber(2),
            "level_count" => fake()->randomNumber(2),
            "has_heating" => fake()->boolean(60),
            "has_hot_water" => fake()->boolean(60),
            "bath" => $randomOption("bath"),
            "bathroom" => $randomOption("bathroom"),
            "area" => fake()->randomNumber(3),
            "room_count" => fake()->randomNumber(1),
            "has_loggia" => fake()->boolean(60),
            "has_balcony" => fake()->boolean(60),
            "has_garage" => fake()->boolean(60),
            "has_garbage_chute" => fake()->boolean(60),
            "has_elevator" => fake()->boolean(60),
            "is_corner" => fake()->boolean(60),
        ];
    }

    public function test(): static {
        return $this->state(fn () => [
            "has_water" => 1,
            "has_gas" => 1,
            "has_electricity" => 1,
            "has_sewer" => 1,
            "condition" => "Euro",
            "walls" => "Brick",
            "ceiling" => 2,
            "level" => 1,
            "level_count" => 1,
            "has_heating" => 1,
            "has_hot_water" => 1,
            "bath" => 1,
            "bathroom" => 1,
            "area" => 1,
            "room_count" => 1,
            "has_loggia" => 1,
            "has_balcony" => 1,
            "has_garage" => 1,
            "has_garbage_chute" => 1,
            "has_elevator" => 1,
            "is_corner" => 1,
        ]);
    }
}
