<?php

namespace Database\Factories;

use App\Actions\GetOptions;
use App\Models\LandParcel;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\LandParcel>
 */
class LandParcelFactory extends Factory {


    public function definition(): array {
        $options = (new GetOptions())->run(LandParcel::class);
        return [
            "water" => $options["water"][array_rand($options["water"])],
            "gas" => $options["gas"][array_rand($options["gas"])],
            "electricity" => $options["electricity"][array_rand($options["electricity"])],
            "sewer" => $options["sewer"][array_rand($options["sewer"])],
            "area" => fake()->randomNumber(3)
        ];
    }
}
