<?php

namespace Tests\Feature;

use App\Models\Address;
use App\Models\User;
use Database\Seeders\AddressOptionsSeeder;
use Database\Seeders\StaticDataSeeder;
use Database\Seeders\TestAddressSeeder;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Artisan;
use Tests\TestCase;

class StoreAddressTest extends AuthorizedTestCase {

    use RefreshDatabase;

    private string $route = "/api/addresses";

    private array $data;

    protected function setUp(): void {
        parent::setUp();
        $this->seed(AddressOptionsSeeder::class);
        $this->data = Address::factory()->test()->make()->toArray();
    }

    public function test_invalid_method_405() {
        $response = $this->getJson($this->route, $this->data);

        $response->assertStatus(405);
    }

    public function test_create_invalid_place_names_data_404() {
        $this->data["street"] = "abcde-abcde-abcde-abcde-abcde-";
        $this->data["city"] = "abcde-abcde-abcde-abcde-abcde-";
        $this->data["number"] = "abcde-";
        $response = $this->postJson($this->route, $this->data);

        $response->assertStatus(404);
    }

    public function test_create_valid_201() {
        $response = $this->postJson($this->route, $this->data);
        $response->assertStatus(201);

        $this->assertDatabaseCount(Address::class, 1);
        $this->assertDatabaseHas(Address::class, $this->data);
    }

    public function test_create_null_unit_201() {
        unset($this->data["unit"]);
        $response = $this->postJson($this->route, $this->data);

        $response->assertStatus(201);
        $this->assertDatabaseCount(Address::class, 1);
        $this->assertDatabaseHas(Address::class, $this->data);
    }

    public function test_create_null_unit_over_non_null_unit_201() {
        $response = $this->postJson($this->route, $this->data);
        unset($this->data["unit"]);
        $response = $this->postJson($this->route, $this->data);

        $response->assertStatus(201);
        $this->assertDatabaseCount(Address::class, 2);
        $this->assertDatabaseHas(Address::class, $this->data);
    }

    public function test_create_null_postal_code_201() {
        unset($this->data["postal_code"]);
        $response = $this->postJson($this->route, $this->data);

        $response->assertStatus(201);

        $this->assertDatabaseCount(Address::class, 1);

        $this->data["latitude"] = 38.87908;
        $this->data["longitude"] = -76.98198;
        $this->assertDatabaseHas(Address::class, $this->data);
    }

    public function test_create_null_postal_code_over_non_null_postal_code_201() {
        $response = $this->postJson($this->route, $this->data);
        unset($this->data["postal_code"]);
        $response = $this->postJson($this->route, $this->data);

        $response->assertStatus(201);
        $this->assertDatabaseCount(Address::class, 2);
        $this->assertDatabaseHas(Address::class, $this->data);
    }

    public function test_create_null_all_nullables_201() {
        unset($this->data["unit"]);
        unset($this->data["postal_code"]);
        $response = $this->postJson($this->route, $this->data);

        $response->assertStatus(201);

        $this->assertDatabaseCount(Address::class, 1);

        $this->data["latitude"] = 38.87908;
        $this->data["longitude"] = -76.98198;
        $this->assertDatabaseHas(Address::class, $this->data);
    }

    public function test_create_existing_address_200() {
        $this->postJson($this->route, $this->data);
        $response = $this->postJson($this->route, $this->data);

        $response->assertStatus(200);
        $this->assertDatabaseCount(Address::class, 1);
        $this->assertDatabaseHas(Address::class, $this->data);
    }
}
