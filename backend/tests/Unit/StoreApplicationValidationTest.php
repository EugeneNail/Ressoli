<?php

namespace Tests\Unit;

use App\Actions\GetOptions;
use App\Http\Controllers\ApplicationController;
use App\Http\Requests\StoreApplicationRequest;
use App\Models\Address;
use App\Models\Apartment;
use App\Models\Application;
use App\Models\Client;
use App\Models\House;
use App\Models\LandParcel;
use Database\Seeders\GlobalOptionsSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Request;
use Illuminate\Routing\Route;
use PHPUnit\Framework\TestCase;

class StoreApplicationValidationTest extends ValidationTestCase {

    use RefreshDatabase;

    private int $landParcelId;

    private int $apartmentId;

    private int $houseId;

    public function setUp(): void {
        parent::setUp();
        $this->seed(GlobalOptionsSeeder::class);
        $this->setRulesFor("land-parcels");
        $this->houseId = House::factory()->create()->id;
        $this->landParcelId = LandParcel::factory()->state(fn () => ["id" => 2])->create()->id;
        $this->apartmentId = Apartment::factory()->state(fn () => ["id" => 3])->create()->id;
    }

    private function setRulesFor(string $applicables): void {
        $request = new StoreApplicationRequest([], [], [], [], [], ["REQUEST_URI" => "applications/" . $applicables]);

        $request->setRouteResolver(function () use ($request) {
            return (new Route("POST", "applications/{applicables}", []))->bind($request);
        });

        $this->rules = $request->rules();
    }

    public function test_client_id_valid_data_success(): void {
        $client = Client::factory()->create();
        $this->assertTrue($this->validate(["client_id", $client->id]));
    }

    public function test_client_id_invalid_data_failure(): void {
        $this->assertFalse($this->validate(["client_id", null]));
        $this->assertFalse($this->validate(["client_id", ""]));
        $this->assertFalse($this->validate(["client_id", "1"]));
        $this->assertFalse($this->validate(["client_id", 0]));
        $this->assertFalse($this->validate(["client_id", -1]));
        $this->assertFalse($this->validate(["client_id", 0.99]));
        $this->assertFalse($this->validate(["client_id", 999]));
    }

    public function test_address_id_valid_data_success(): void {
        $address = Address::factory()->create();
        $this->assertTrue($this->validate(["address_id", $address->id]));
    }

    public function test_address_id_invalid_data_failure(): void {
        $this->assertFalse($this->validate(["address_id", null]));
        $this->assertFalse($this->validate(["address_id", ""]));
        $this->assertFalse($this->validate(["address_id", "1"]));
        $this->assertFalse($this->validate(["address_id", 0]));
        $this->assertFalse($this->validate(["address_id", -1]));
        $this->assertFalse($this->validate(["address_id", 0.99]));
        $this->assertFalse($this->validate(["address_id", 999]));
    }

    public function test_land_parcel_id_valid_data_success(): void {
        $this->setRulesFor("land-parcels");
        $this->assertTrue($this->validate(["applicable_id", $this->landParcelId]));
    }

    public function test_land_parcel_id_invalid_data_failure(): void {
        $this->setRulesFor("land-parcels");
        $this->assertFalse($this->validate(["applicable_id", null]));
        $this->assertFalse($this->validate(["applicable_id", 0]));
        $this->assertFalse($this->validate(["applicable_id", -1]));
        $this->assertFalse($this->validate(["applicable_id", 0.99]));
        $this->assertFalse($this->validate(["applicable_id", "test"]));
    }

    public function test_house_id_valid_data_success(): void {
        $this->setRulesFor("houses");
        $this->assertTrue($this->validate(["applicable_id", $this->houseId]));
    }

    public function test_house_id_invalid_data_failure(): void {
        $this->setRulesFor("houses");
        $this->assertFalse($this->validate(["applicable_id", null]));
        $this->assertFalse($this->validate(["applicable_id", 0]));
        $this->assertFalse($this->validate(["applicable_id", -1]));
        $this->assertFalse($this->validate(["applicable_id", 0.99]));
        $this->assertFalse($this->validate(["applicable_id", "test"]));
    }

    public function test_apartment_id_valid_data_success(): void {
        $this->setRulesFor("apartments");
        $this->assertTrue($this->validate(["applicable_id", $this->apartmentId]));
    }

    public function test_apartment_id_invalid_data_failure(): void {
        $this->setRulesFor("apartments");
        $this->assertFalse($this->validate(["applicable_id", null]));
        $this->assertFalse($this->validate(["applicable_id", 0]));
        $this->assertFalse($this->validate(["applicable_id", -1]));
        $this->assertFalse($this->validate(["applicable_id", 0.99]));
        $this->assertFalse($this->validate(["applicable_id", "test"]));
    }

    public function test_contract_valid_data_success(): void {
        $options = app()->make(GetOptions::class)->run(Application::class);
        $this->assertTrue($this->validate(["contract", $options["contract"][0]]));
    }

    public function test_contract_invalid_data_failure(): void {
        $this->assertFalse($this->validate(["contract", null]));
        $this->assertFalse($this->validate(["contract", ""]));
        $this->assertFalse($this->validate(["contract", 123]));
        $this->assertFalse($this->validate(["contract", "Invalid"]));
    }

    public function test_price_valid_data_success(): void {
        $this->assertTrue($this->validate(["price", 1]));
        $this->assertTrue($this->validate(["price", 10000000]));
        $this->assertTrue($this->validate(["price", 1234567]));
    }

    public function test_price_invalid_data_failure(): void {
        $this->assertFalse($this->validate(["price", null]));
        $this->assertFalse($this->validate(["price", ""]));
        $this->assertFalse($this->validate(["price", "test"]));
        $this->assertFalse($this->validate(["price", 0]));
        $this->assertFalse($this->validate(["price", -1]));
        $this->assertFalse($this->validate(["price", 1.01]));
        $this->assertFalse($this->validate(["price", 10000001]));
    }

    public function test_has_mortgage_valid_data_success(): void {
        $this->assertTrue($this->validate(["has_mortgage", true]));
        $this->assertTrue($this->validate(["has_mortgage", false]));
        $this->assertTrue($this->validate(["has_mortgage", 1]));
        $this->assertTrue($this->validate(["has_mortgage", 0]));
        $this->assertTrue($this->validate(["has_mortgage", "1"]));
        $this->assertTrue($this->validate(["has_mortgage", "0"]));
    }

    public function test_has_mortgage_invalid_data_failure(): void {
        $this->assertFalse($this->validate(["has_mortgage", -1]));
        $this->assertFalse($this->validate(["has_mortgage", ""]));
        $this->assertFalse($this->validate(["has_mortgage", "asdasdasd"]));
        $this->assertFalse($this->validate(["has_mortgage", "on"]));
        $this->assertFalse($this->validate(["has_mortgage", "off"]));
        $this->assertFalse($this->validate(["has_mortgage", null]));
        $this->assertFalse($this->validate(["has_mortgage", "yes"]));
        $this->assertFalse($this->validate(["has_mortgage", "no"]));
    }
}
