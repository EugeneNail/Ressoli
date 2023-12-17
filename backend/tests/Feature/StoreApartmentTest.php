<?php

namespace Tests\Feature;

use App\Models\Apartment;
use Database\Seeders\ApartmentOptionsSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class StoreApartmentTest extends AuthorizedTestCase {

    public function setUp(): void {
        parent::setUp();
        $this->seed(ApartmentOptionsSeeder::class);
        $this->route = "/api/apartments";
        $this->data = Apartment::factory()->test()->make()->toArray();
    }

    public function test_store_valid_data_201(): void {
        $response = $this->postJson($this->route, $this->data);
        $id = $response->getContent();

        $response->assertStatus(201);
        $this->assertDatabaseHas(Apartment::class, ["id" => $id] + $this->data);
        $this->assertDatabaseCount(Apartment::class, 1);
        $this->assertIsInt(json_decode($response->getContent()));
    }

    public function test_store_invalid_data_422(): void {
        $response = $this->postJson($this->route, []);

        $response->assertStatus(422);
        $this->assertDatabaseCount(Apartment::class, 0);
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
}
