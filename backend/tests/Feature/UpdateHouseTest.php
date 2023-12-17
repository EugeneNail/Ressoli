<?php

namespace Tests\Feature;

use App\Models\House;
use Database\Seeders\HouseOptionsSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UpdateHouseTest extends AuthorizedTestCase {

    public function setUp(): void {
        parent::setUp();
        $this->seed(HouseOptionsSeeder::class);
        $this->route = "/api/houses";
        $this->data = House::factory()->test()->make()->toArray();
        House::factory()->create();
    }

    public function test_update_valid_data_204(): void {
        $response = $this->putJson($this->route . "/1", $this->data);

        $response->assertStatus(204);
        $this->assertDatabaseHas(House::class, ["id" => 1] + $this->data);
        $this->assertDatabaseCount(House::class, 1);
        $this->assertNull(json_decode($response->getContent()));
    }

    public function test_update_invalid_data_422(): void {
        $response = $this->postJson($this->route, []);
        $response->assertStatus(422);
        $this->assertDatabaseCount(House::class, 1);
        $response->assertJsonValidationErrors([
            "water",
            "gas",
            "electricity",
            "sewer",
            "condition",
            "walls",
            "roof",
            "floor",
            "levelCount",
            "hotWater",
            "heating",
            "bath",
            "bathroom",
            "roomCount",
            "area",
            "kitchenArea",
            "landArea",
        ]);
    }

    public function test_update_invalid_id_404(): void {
        $response = $this->putJson($this->route . "/999", $this->data);

        $response->assertStatus(404);
        $this->assertDatabaseCount(House::class, 1);
        $this->assertDatabaseMissing(House::class, ["id" => 1] + $this->data);
    }
}
