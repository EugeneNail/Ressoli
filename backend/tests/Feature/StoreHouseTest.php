<?php

namespace Tests\Feature;

use App\Models\House;
use Database\Seeders\HouseOptionsSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class StoreHouseTest extends AuthorizedTestCase {

    private string $route = "/api/houses";

    private array $data;

    public function setUp(): void {
        parent::setUp();
        $this->seed(HouseOptionsSeeder::class);
        $this->data = House::factory()->test()->make()->toArray();
    }

    public function test_store_valid_data_201(): void {
        $response = $this->postJson($this->route, $this->data);
        $id = $response->content();

        $response->assertStatus(201);
        $this->assertDatabaseHas(House::class, ["id" => $id] + $this->data);
        $this->assertDatabaseCount(House::class, 1);
        $this->assertIsInt(json_decode($response->getContent()));
    }

    public function test_store_invalid_data_422(): void {
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
}
