<?php

namespace Tests\Feature;

use App\Models\LandParcel;
use Database\Seeders\LandParcelOptionsSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class StoreLandParcelTest extends AuthorizedTestCase {

    private array $data;

    private string $route = "/api/land-parcels";

    public function setUp(): void {
        parent::setUp();
        $this->seed(LandParcelOptionsSeeder::class);
        $this->data = LandParcel::factory()->test()->make()->toArray();
    }

    public function test_store_valid_data_201(): void {
        $response = $this->postJson($this->route, $this->data);

        $response->assertStatus(201);
        $this->assertDatabaseHas(LandParcel::class, $this->data);
    }

    public function test_store_invalid_data_422(): void {
        $response = $this->postJson($this->route, []);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(["water", "electricity", "sewer", "gas"]);
        $this->assertDatabaseCount(LandParcel::class, 0);
    }

    public function test_store_existing_data_201(): void {
        $this->postJson($this->route, $this->data);
        $response = $this->postJson($this->route, $this->data);

        $response->assertStatus(201);
        $this->assertDatabaseCount(LandParcel::class, 2);
    }
}
