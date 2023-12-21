<?php

namespace Tests\Feature;

use App\Models\Application;
use App\Models\User;
use Database\Seeders\GlobalOptionsSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UpdateApplicationTest extends AuthorizedTestCase {

    use RefreshDatabase;

    public function setUp(): void {
        parent::setUp();
        $this->route = "/api/applications";
        $this->seed(GlobalOptionsSeeder::class);
    }

    public function test_update_invalid_data_422(): void {
        Application::factory()->withHouse()->create();
        $response = $this->putJson($this->route . "/houses" . "/1", []);

        $response->assertStatus(422);
        $this->assertDatabaseCount(Application::class, 1);
        $response->assertJsonValidationErrors([
            "clientId",
            "addressId",
            "applicableId",
            "price",
            "contract",
        ]);
    }

    public function test_update_empty_applicable_405(): void {
        Application::factory()->withHouse()->create();
        $this->data = Application::factory()->withHouse()->make()->toArray();
        $response = $this->putJson($this->route . "/1", $this->data);

        $response->assertStatus(405);
        $this->assertDatabaseCount(Application::class, 1);
        $this->assertDatabaseMissing(Application::class, $this->data);
    }

    public function test_update_invalid_applicable_404(): void {
        Application::factory()->withHouse()->create();
        $this->data = Application::factory()->withHouse()->make()->toArray();
        $response = $this->putJson($this->route . "/house" . "/1", $this->data);

        $response->assertStatus(404);
        $this->assertDatabaseCount(Application::class, 1);
        $this->assertDatabaseMissing(Application::class, $this->data);
    }

    public function test_update_valid_data_house_204(): void {
        $user = User::find(1);
        Application::factory()
            ->withHouse()
            ->withUser($user)
            ->active()
            ->create();
        $this->data = Application::factory()
            ->withHouse()
            ->withUser($user)
            ->active()
            ->make()
            ->toArray();
        $response = $this->putJson($this->route . "/houses" . "/1", $this->data);

        $response->assertStatus(204);
        $this->assertDatabaseCount(Application::class, 1);
        $this->assertDatabaseHas(Application::class, ["id" => 1] + $this->data);
        $this->assertNull(json_decode($response->getContent()));
    }

    public function test_update_valid_data_land_parcel_204(): void {
        $user = User::find(1);
        Application::factory()
            ->withLandParcel()
            ->withUser($user)
            ->active()
            ->create();
        $this->data = Application::factory()
            ->withLandParcel()
            ->withUser($user)
            ->active()
            ->make()
            ->toArray();
        $response = $this->putJson($this->route . "/land-parcels" . "/1", $this->data);

        $response->assertStatus(204);
        $this->assertDatabaseCount(Application::class, 1);
        $this->assertDatabaseHas(Application::class, ["id" => 1] + $this->data);
        $this->assertNull(json_decode($response->getContent()));
    }

    public function test_update_valid_data_apartment_204(): void {
        $user = User::find(1);
        Application::factory()->withApartment()
            ->withUser($user)
            ->active()
            ->create();
        $this->data = Application::factory()
            ->withApartment()
            ->withUser($user)
            ->active()
            ->make()
            ->toArray();
        $response = $this->putJson($this->route . "/apartments" . "/1", $this->data);

        $response->assertStatus(204);
        $this->assertDatabaseCount(Application::class, 1);
        $this->assertDatabaseHas(Application::class, ["id" => 1] + $this->data);
        $this->assertNull(json_decode($response->getContent()));
    }
}
