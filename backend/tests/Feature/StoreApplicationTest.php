<?php

namespace Tests\Feature;

use App\Models\Address;
use App\Models\Apartment;
use App\Models\Application;
use App\Models\Client;
use App\Models\House;
use App\Models\LandParcel;
use Database\Seeders\GlobalOptionsSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class StoreApplicationTest extends AuthorizedTestCase {

    use RefreshDatabase;

    public function setUp(): void {
        parent::setUp();
        $this->route = "/api/applications";
        $this->seed(GlobalOptionsSeeder::class);
    }

    public function test_store_invalid_applicable_404(): void {
        $this->data = Application::factory()->withHouse()->make()->toArray();
        $response = $this->postJson($this->route . "/house", $this->data);
        $response->assertStatus(404);
        $this->assertDatabaseCount(Application::class, 0);
    }

    public function test_store_no_applicable_404(): void {
        $this->data = Application::factory()->withHouse()->make()->toArray();
        $response = $this->postJson($this->route, $this->data);
        $response->assertStatus(404);
        $this->assertDatabaseCount(Application::class, 0);
    }

    public function test_store_invalid_data_422(): void {
        $response = $this->postJson($this->route . "/houses", []);
        $response->assertStatus(422);
        $this->assertDatabaseCount(Application::class, 0);
        $response->assertJsonValidationErrors([
            "clientId",
            "addressId",
            "applicableId",
            "price",
            "contract",
        ]);
    }

    public function test_store_valid_data_house_201(): void {
        $this->data = Application::factory()->withHouse()->make()->toArray();
        $response = $this->postJson($this->route . "/houses", $this->data);

        $response->assertStatus(201);
        $this->assertIsInt(json_decode($response->getContent()));

        $id = $response->getContent();
        $savedApplicationData = [
            "id" => $id,
            "applicable_type" => House::class,
            "is_active" => true,
            "user_id" => 1
        ] + $this->data;
        $this->assertDatabaseHas(Application::class, $savedApplicationData);

        $application = Application::find($id);
        $this->assertDatabaseHas(Client::class, ["id" => $application->client_id]);
        $this->assertDatabaseHas(Address::class, ["id" => $application->address_id]);
        $this->assertDatabaseHas(House::class, ["id" => $application->applicable_id]);
        $this->assertDatabaseCount(Application::class, 1);
    }

    public function test_store_valid_data_land_parcel_201(): void {
        $this->data = Application::factory()->withLandParcel()->make()->toArray();
        $response = $this->postJson($this->route . "/land-parcels", $this->data);

        $response->assertStatus(201);
        $this->assertIsInt(json_decode($response->getContent()));

        $id = $response->getContent();
        $savedApplicationData = [
            "id" => $id,
            "applicable_type" => LandParcel::class,
            "is_active" => true,
            "user_id" => 1
        ] + $this->data;
        $this->assertDatabaseHas(Application::class, $savedApplicationData);

        $application = Application::find($id);
        $this->assertDatabaseHas(Client::class, ["id" => $application->client_id]);
        $this->assertDatabaseHas(Address::class, ["id" => $application->address_id]);
        $this->assertDatabaseHas(LandParcel::class, ["id" => $application->applicable_id]);
        $this->assertDatabaseCount(Application::class, 1);
    }

    public function test_store_valid_data_apartment_201(): void {
        $this->data = Application::factory()->withApartment()->make()->toArray();
        $response = $this->postJson($this->route . "/apartments", $this->data);

        $response->assertStatus(201);
        $this->assertIsInt(json_decode($response->getContent()));

        $id = $response->getContent();
        $savedApplicationData = [
            "id" => $id,
            "applicable_type" => Apartment::class,
            "is_active" => true,
            "user_id" => 1
        ] + $this->data;
        $this->assertDatabaseHas(Application::class, $savedApplicationData);

        $application = Application::find($id);
        $this->assertDatabaseHas(Client::class, ["id" => $application->client_id]);
        $this->assertDatabaseHas(Address::class, ["id" => $application->address_id]);
        $this->assertDatabaseHas(Apartment::class, ["id" => $application->applicable_id]);
        $this->assertDatabaseCount(Application::class, 1);
    }
}
