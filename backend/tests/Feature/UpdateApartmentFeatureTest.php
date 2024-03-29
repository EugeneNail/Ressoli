<?php

namespace Tests\Feature;

use App\Models\Apartment;
use Database\Seeders\ApartmentOptionsSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UpdateApartmentFeatureTest extends AuthorizedTestCase {

    public function setUp(): void {
        parent::setUp();
        $this->seed(ApartmentOptionsSeeder::class);
        $this->route = "/api/apartments";
        $this->data = Apartment::factory()->test()->make()->toArray();
        Apartment::factory()->create();
    }

    public function test_valid_data_204(): void {
        $response = $this->putJson($this->route . "/1", $this->data);

        $response->assertStatus(204);
        $this->assertDatabaseCount(Apartment::class, 1);
        $this->assertDatabaseHas(Apartment::class, ["id" => 1] + $this->data);
        $this->assertNull(json_decode($response->getContent()));
    }

    public function test_invalid_data_422(): void {
        $response = $this->putJson($this->route . "/1", []);

        $response->assertStatus(422);
        $this->assertDatabaseCount(Apartment::class, 1);
        $this->assertDatabaseMissing(Apartment::class, ["id" => 1] + $this->data);
        $response->assertJsonValidationErrors([
            "condition",
            "walls",
            "ceiling",
            "level",
            "levelCount",
            "bath",
            "bathroom",
            "area",
            "roomCount",
        ]);
    }

    public function test_invalid_id_404(): void {
        $response = $this->putJson($this->route . "/999", $this->data);

        $response->assertStatus(404);
        $this->assertDatabaseCount(Apartment::class, 1);
        $this->assertDatabaseMissing(Apartment::class, ["id" => 1] + $this->data);
    }
}
