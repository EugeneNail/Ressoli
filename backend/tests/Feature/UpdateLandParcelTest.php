<?php

namespace Tests\Feature;

use App\Models\LandParcel;
use Database\Seeders\LandParcelOptionsSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UpdateLandParcelTest extends AuthorizedTestCase {

    public function setUp(): void {
        parent::setUp();
        $this->seed(LandParcelOptionsSeeder::class);
        $this->route = "/api/land-parcels";
        $this->data = LandParcel::factory()->test()->make()->toArray();
        LandParcel::factory()->create();
    }

    public function test_update_valid_data_204(): void {
        $response = $this->putJson($this->route . "/1", $this->data);

        $response->assertStatus(204);
        $this->assertDatabaseCount(LandParcel::class, 1);
        $this->assertDatabaseHas(LandParcel::class, ["id" => 1] + $this->data);
        $this->assertNull(json_decode($response->getContent()));
    }

    public function test_update_invalid_id_404(): void {
        $response = $this->putJson($this->route . "/999", $this->data);

        $response->assertStatus(404);
        $this->assertDatabaseCount(LandParcel::class, 1);
        $this->assertDatabaseMissing(LandParcel::class, ["id" => 1] + $this->data);
    }

    public function test_update_invalid_data_422(): void {
        $response = $this->putJson($this->route . "/1", []);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(["water", "gas", "electricity", "sewer", "area"]);
        $this->assertDatabaseCount(LandParcel::class, 1);
    }
}
