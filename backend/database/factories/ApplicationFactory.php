<?php

namespace Database\Factories;

use App\Actions\GetOptions;
use App\Models\Application;
use App\Models\LandParcel;
use App\Models\Apartment;
use App\Models\House;
use App\Models\Address;
use App\Models\Client;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Application>
 */
class ApplicationFactory extends Factory {
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array {
        $options = app()->make(GetOptions::class)->run(Application::class);
        $randomOption = function (string $name) use ($options) {
            return $options[$name][array_rand($options[$name])];
        };

        return [
            "is_active" => fake()->boolean(),
            "price" => fake()->randomNumber(7),
            "has_mortgage" => fake()->boolean(),
            "contract" => $randomOption("contract"),
            "user_id" => User::factory(),
            "client_id" => Client::factory(),
            "address_id" => Address::factory(),
        ];
    }

    public function withHouse(): static {
        return $this->state(function () {
            $house = House::factory()->create();
            return    [
                "applicable_id" => $house->id,
                "applicable_type" => House::class
            ];
        });
    }

    public function withApartment(): static {
        return $this->state(function () {
            $apartment = Apartment::factory()->create();
            return [
                "applicable_id" => $apartment->id,
                "applicable_type" => Apartment::class
            ];
        });
    }

    public function withLandParcel(): static {
        return $this->state(function () {
            $landParcel = LandParcel::factory()->create();
            return [
                "applicable_id" => $landParcel->id,
                "applicable_type" => LandParcel::class
            ];
        });
    }

    public function withRandomApplicable(): static {
        return $this->state(function () {
            $modelClasses = [
                House::class,
                LandParcel::class,
                Apartment::class
            ];
            $applicableClass = $modelClasses[fake()->numberBetween(0, 2)];
            $applicable = $applicableClass::factory()->create();

            return [
                "applicable_id" => $applicable->id,
                "applicable_type" => get_class($applicable)
            ];
        });
    }

    public function active(): static {
        return $this->state(fn () => ["is_active" => true]);
    }

    public function inactive(): static {
        return $this->state(fn () => ["is_active" => false]);
    }

    public function withUser(User $user) {
        return $this->state(fn () => ["user_id" => $user]);
    }
}
