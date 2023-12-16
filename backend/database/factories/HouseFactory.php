<?php

namespace Database\Factories;

use App\Actions\GetOptions;
use App\Models\House;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\House>
 */
class HouseFactory extends Factory {


    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array {
        $options = app()->make(GetOptions::class)->run(House::class);
        $randomOption = function (string $name) use ($options) {
            return $options[$name][array_rand($options[$name])];
        };

        return [
            "water" => $randomOption("water"),
            "gas" => $randomOption("gas"),
            "electricity" => $randomOption("electricity"),
            "sewer" => $randomOption("sewer"),
            "walls" => $randomOption("walls"),
            "condition" => $randomOption("condition"),
            "roof" => $randomOption("roof"),
            "floor" => $randomOption("floor"),
            "level_count" => fake()->randomNumber(2),
            "has_garage" => fake()->boolean(),
            "hot_water" => $randomOption("hot_water"),
            "heating" => $randomOption("heating"),
            "bath" => $randomOption("bath"),
            "bathroom" => $randomOption("bathroom"),
            "room_count" => fake()->randomNumber(2),
            "area" => fake()->randomNumber(4),
            "kitchen_area" => fake()->randomNumber(3),
            "land_area" => fake()->randomNumber(4),
        ];
    }

    public function test(): static {
        return $this->state(fn () => [
            "water" => "None",
            "gas" => "None",
            "electricity" => "None",
            "sewer" => "None",
            "walls" => "Brick",
            "condition" => "Euro",
            "roof" => "Ondulin",
            "floor" => "Hardwood",
            "level_count" => "10",
            "has_garage" => 1,
            "hot_water" => "None",
            "heating" => "None",
            "bath" => "None",
            "bathroom" => "None",
            "room_count" => "10",
            "area" => "1234",
            "kitchen_area" => "123",
            "land_area" => "1234",
        ]);
    }
}
