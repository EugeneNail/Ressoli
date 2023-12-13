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

    private array $data = [
        "number" => "1600",
        "unit" => "234b",
        "street" => "Pennsylvania",
        "typeOfStreet" => "Ave",
        "city" => "Washington",
        "postalCode" => "20500",
        "latitude" => 38.89768,
        "longitude" => -77.03655,
    ];

    protected function setUp(): void {
        parent::setUp();
        $this->seed(AddressOptionsSeeder::class);
    }

    public function test_invalid_method_405() {
        $response = $this->getJson($this->route, $this->data);
        $response->assertStatus(405);
    }

    public function test_number_invalid_required_422() {
        unset($this->data["number"]);
        $response = $this->postJson($this->route, $this->data);
        $response->assertStatus(422);
    }

    public function test_number_invalid_string_422() {
        $this->data["number"] = 123;
        $response = $this->postJson($this->route, $this->data);
        $response->assertStatus(422);
    }

    public function test_number_invalid_ssand_1_422() {
        $this->data["number"] .= "?";
        $response = $this->postJson($this->route, $this->data);
        $response->assertStatus(422);
    }

    public function test_number_invalid_ssand_2_422() {
        $this->data["number"] .= "%";
        $response = $this->postJson($this->route, $this->data);
        $response->assertStatus(422);
    }

    public function test_number_invalid_ssand_3_422() {
        $this->data["number"] .= "*";
        $response = $this->postJson($this->route, $this->data);
        $response->assertStatus(422);
    }

    public function test_number_invalid_ssand_4_422() {
        $this->data["number"] .= "|";
        $response = $this->postJson($this->route, $this->data);
        $response->assertStatus(422);
    }

    public function test_number_invalid_max_422() {
        $this->data["number"] = "abcdefghi";
        $response = $this->postJson($this->route, $this->data);
        $response->assertStatus(422);
    }

    public function test_unit_invalid_string_422() {
        $this->data["unit"] = 123;
        $response = $this->postJson($this->route, $this->data);
        $response->assertStatus(422);
    }

    public function test_unit_invalid_ssand_1_422() {
        $this->data["unit"] .= "?";
        $response = $this->postJson($this->route, $this->data);
        $response->assertStatus(422);
    }

    public function test_unit_invalid_ssand_2_422() {
        $this->data["unit"] .= "%";
        $response = $this->postJson($this->route, $this->data);
        $response->assertStatus(422);
    }

    public function test_unit_invalid_ssand_3_422() {
        $this->data["unit"] .= "*";
        $response = $this->postJson($this->route, $this->data);
        $response->assertStatus(422);
    }

    public function test_unit_invalid_ssand_4_422() {
        $this->data["unit"] .= "|";
        $response = $this->postJson($this->route, $this->data);
        $response->assertStatus(422);
    }

    public function test_unit_invalid_max_422() {
        $this->data["unit"] = "abcdefghi";
        $response = $this->postJson($this->route, $this->data);
        $response->assertStatus(422);
    }

    public function test_street_invalid_required_422() {
        unset($this->data["street"]);
        $response = $this->postJson($this->route, $this->data);
        $response->assertStatus(422);
    }

    public function test_street_invalid_string_422() {
        $this->data["street"] = 123;
        $response = $this->postJson($this->route, $this->data);
        $response->assertStatus(422);
    }

    public function test_street_invalid_ssand_1_422() {
        $this->data["street"] .= "?";
        $response = $this->postJson($this->route, $this->data);
        $response->assertStatus(422);
    }

    public function test_street_invalid_ssand_2_422() {
        $this->data["street"] .= "%";
        $response = $this->postJson($this->route, $this->data);
        $response->assertStatus(422);
    }

    public function test_street_invalid_ssand_3_422() {
        $this->data["street"] .= "*";
        $response = $this->postJson($this->route, $this->data);
        $response->assertStatus(422);
    }

    public function test_street_invalid_ssand_4_422() {
        $this->data["street"] .= "|";
        $response = $this->postJson($this->route, $this->data);
        $response->assertStatus(422);
    }

    public function test_street_invalid_max_422() {
        $this->data["street"] = "abcdefg-abcdefg-abcdefg-abcdefg-abcdefg";
        $response = $this->postJson($this->route, $this->data);
        $response->assertStatus(422);
    }

    public function test_city_invalid_required_422() {
        unset($this->data["city"]);
        $response = $this->postJson($this->route, $this->data);
        $response->assertStatus(422);
    }

    public function test_city_invalid_string_422() {
        $this->data["city"] = 123;
        $response = $this->postJson($this->route, $this->data);
        $response->assertStatus(422);
    }

    public function test_city_invalid_ssand_1_422() {
        $this->data["city"] .= "?";
        $response = $this->postJson($this->route, $this->data);
        $response->assertStatus(422);
    }

    public function test_city_invalid_ssand_2_422() {
        $this->data["city"] .= "%";
        $response = $this->postJson($this->route, $this->data);
        $response->assertStatus(422);
    }

    public function test_city_invalid_ssand_3_422() {
        $this->data["city"] .= "*";
        $response = $this->postJson($this->route, $this->data);
        $response->assertStatus(422);
    }

    public function test_city_invalid_ssand_4_422() {
        $this->data["city"] .= "|";
        $response = $this->postJson($this->route, $this->data);
        $response->assertStatus(422);
    }

    public function test_city_invalid_max_422() {
        $this->data["city"] = "abcdefg-abcdefg-abcdefg-abcdefg-abcdefg";
        $response = $this->postJson($this->route, $this->data);
        $response->assertStatus(422);
    }

    public function test_postal_code_invalid_string_422() {
        $this->data["postalCode"] = 123;
        $response = $this->postJson($this->route, $this->data);
        $response->assertStatus(422);
    }

    public function test_postal_code_invalid_ssand_1_422() {
        $this->data["postalCode"] .= "?";
        $response = $this->postJson($this->route, $this->data);
        $response->assertStatus(422);
    }

    public function test_postal_code_invalid_ssand_2_422() {
        $this->data["postalCode"] .= "%";
        $response = $this->postJson($this->route, $this->data);
        $response->assertStatus(422);
    }

    public function test_postal_code_invalid_ssand_3_422() {
        $this->data["postalCode"] .= "*";
        $response = $this->postJson($this->route, $this->data);
        $response->assertStatus(422);
    }

    public function test_postal_code_invalid_ssand_4_422() {
        $this->data["postalCode"] .= "|";
        $response = $this->postJson($this->route, $this->data);
        $response->assertStatus(422);
    }

    public function test_postal_code_invalid_max_422() {
        $this->data["postalCode"] = "abcdefg-abcdefg-abcdefg";
        $response = $this->postJson($this->route, $this->data);
        $response->assertStatus(422);
    }

    public function test_type_of_street_invalid_required_422() {
        unset($this->data["typeOfStreet"]);
        $response = $this->postJson($this->route, $this->data);
        $response->assertStatus(422);
    }

    public function test_type_of_street_invalid_string_422() {
        $this->data["typeOfStreet"] = 123;
        $response = $this->postJson($this->route, $this->data);
        $response->assertStatus(422);
    }

    public function test_type_of_street_invalid_in_array_422() {
        $this->data["typeOfStreet"] = "test";
        $response = $this->postJson($this->route, $this->data);
        $response->assertStatus(422);
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
        $this->assertDatabaseHas(Address::class, [
            "number" => $this->data["number"],
            "unit" => $this->data["unit"],
            "street" => $this->data["street"],
            "type_of_street" => $this->data["typeOfStreet"],
            "city" => $this->data["city"],
            "postal_code" => $this->data["postalCode"],
            "latitude" => $this->data["latitude"],
            "longitude" => $this->data["longitude"],
        ]);
    }

    public function test_create_null_unit_201() {
        unset($this->data["unit"]);
        $response = $this->postJson($this->route, $this->data);
        $response->assertStatus(201);
        $this->assertDatabaseCount(Address::class, 1);
        $this->assertDatabaseHas(Address::class, [
            "number" => $this->data["number"],
            "unit" => null,
            "street" => $this->data["street"],
            "type_of_street" => $this->data["typeOfStreet"],
            "city" => $this->data["city"],
            "postal_code" => $this->data["postalCode"],
            "latitude" => $this->data["latitude"],
            "longitude" => $this->data["longitude"],
        ]);
    }

    public function test_create_null_unit_over_non_null_unit_201() {
        $response = $this->postJson($this->route, $this->data);
        unset($this->data["unit"]);
        $response = $this->postJson($this->route, $this->data);
        $response->assertStatus(201);
        $this->assertDatabaseCount(Address::class, 2);
        $this->assertDatabaseHas(Address::class, [
            "number" => $this->data["number"],
            "unit" => null,
            "street" => $this->data["street"],
            "type_of_street" => $this->data["typeOfStreet"],
            "city" => $this->data["city"],
            "postal_code" => $this->data["postalCode"],
            "latitude" => $this->data["latitude"],
            "longitude" => $this->data["longitude"],
        ]);
    }

    public function test_create_null_postal_code_201() {
        unset($this->data["postalCode"]);
        $response = $this->postJson($this->route, $this->data);
        $response->assertStatus(201);
        $this->assertDatabaseCount(Address::class, 1);
        $this->assertDatabaseHas(Address::class, [
            "number" => $this->data["number"],
            "unit" => $this->data["unit"],
            "street" => $this->data["street"],
            "type_of_street" => $this->data["typeOfStreet"],
            "city" => $this->data["city"],
            "postal_code" => null,
            "latitude" => 38.87908,
            "longitude" => -76.98198
        ]);
    }

    public function test_create_null_postal_code_over_non_null_postal_code_201() {
        $response = $this->postJson($this->route, $this->data);
        unset($this->data["postalCode"]);
        $response = $this->postJson($this->route, $this->data);
        $response->assertStatus(201);
        $this->assertDatabaseCount(Address::class, 2);
        $this->assertDatabaseHas(Address::class, [
            "number" => $this->data["number"],
            "unit" => $this->data["unit"],
            "street" => $this->data["street"],
            "type_of_street" => $this->data["typeOfStreet"],
            "city" => $this->data["city"],
            "postal_code" => null,
            "latitude" => 38.87908,
            "longitude" => -76.98198
        ]);
    }

    public function test_create_null_all_nullables_201() {
        unset($this->data["unit"]);
        unset($this->data["postalCode"]);
        $response = $this->postJson($this->route, $this->data);
        $response->assertStatus(201);
        $this->assertDatabaseCount(Address::class, 1);
        $this->assertDatabaseHas(Address::class, [
            "number" => $this->data["number"],
            "unit" => null,
            "street" => $this->data["street"],
            "type_of_street" => $this->data["typeOfStreet"],
            "city" => $this->data["city"],
            "postal_code" => null,
            "latitude" => 38.87908,
            "longitude" => -76.98198
        ]);
    }

    public function test_create_existing_address_200() {
        $this->postJson($this->route, $this->data);
        $response = $this->postJson($this->route, $this->data);
        $response->assertStatus(200);
        $this->assertDatabaseCount(Address::class, 1);
        $this->assertDatabaseHas(Address::class, [
            "number" => $this->data["number"],
            "unit" => $this->data["unit"],
            "street" => $this->data["street"],
            "type_of_street" => $this->data["typeOfStreet"],
            "city" => $this->data["city"],
            "postal_code" => $this->data["postalCode"],
            "latitude" => $this->data["latitude"],
            "longitude" => $this->data["longitude"],
        ]);
    }
}
