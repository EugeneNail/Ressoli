<?php

namespace Tests\Feature;

use App\Models\House;
use Database\Seeders\HouseOptionsSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UpdateHouseTest extends AuthorizedTestCase {
    private string $route = "/api/houses";

    private array $data;

    public function setUp(): void {
        parent::setUp();
        $this->seed(HouseOptionsSeeder::class);
        $this->data = House::factory()->test()->make()->toArray();
    }

    public function test_update_valid_data_204(): void {
        $house = House::factory()->create();
        $id = $house->id;
        $response = $this->putJson($this->route . "/" . $id, $this->data);

        $response->assertStatus(204);
        $this->assertDatabaseHas(House::class, ["id" => $id] + $this->data);
        $this->assertDatabaseCount(House::class, 1);
        $this->assertNull(json_decode($response->getContent()));
    }

    public function test_update_invalid_data_422(): void {
        $response = $this->postJson($this->route, []);
        $response->assertStatus(422);
        $this->assertDatabaseCount(House::class, 0);
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
        $house = House::factory()->create();
        $response = $this->putJson($this->route . "/999", $this->data);

        $response->assertStatus(404);
        $this->assertDatabaseCount(House::class, 1);
        $this->assertDatabaseMissing(House::class, ["id" => $house->id] + $this->data);
    }
}
