<?php

namespace Tests\Unit;

use App\Actions\GetOptions;
use App\Http\Requests\StoreHouseRequest;
use App\Models\House;
use Database\Seeders\HouseOptionsSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Validator;

class StoreHouseValidationTest extends ValidationTestCase {

    use RefreshDatabase;

    private array $options;

    public function setUp(): void {
        parent::setUp();
        $this->seed(HouseOptionsSeeder::class);
        $this->rules = (new StoreHouseRequest())->rules();
        $this->options = app()->make(GetOptions::class)->run(House::class);
    }

    public function test_water_valid_data_success(): void {
        $this->assertTrue($this->validate(["water", $this->options["water"][0]]));
    }

    public function test_water_invalid_data_failure(): void {
        $this->assertFalse($this->validate(["water", null]));
        $this->assertFalse($this->validate(["water", ""]));
        $this->assertFalse($this->validate(["water", 123]));
        $this->assertFalse($this->validate(["water", "Invalid"]));
    }

    public function test_gas_valid_data_success(): void {
        $this->assertTrue($this->validate(["gas", $this->options["gas"][0]]));
    }

    public function test_gas_invalid_data_failure(): void {
        $this->assertFalse($this->validate(["gas", null]));
        $this->assertFalse($this->validate(["gas", ""]));
        $this->assertFalse($this->validate(["gas", 123]));
        $this->assertFalse($this->validate(["gas", "Invalid"]));
    }

    public function test_electricity_valid_data_success(): void {
        $this->assertTrue($this->validate(["electricity", $this->options["electricity"][0]]));
    }

    public function test_electricity_invalid_data_failure(): void {
        $this->assertFalse($this->validate(["electricity", null]));
        $this->assertFalse($this->validate(["electricity", ""]));
        $this->assertFalse($this->validate(["electricity", 123]));
        $this->assertFalse($this->validate(["electricity", "Invalid"]));
    }

    public function test_sewer_valid_data_success(): void {
        $this->assertTrue($this->validate(["sewer", $this->options["sewer"][0]]));
    }

    public function test_sewer_invalid_data_failure(): void {
        $this->assertFalse($this->validate(["sewer", null]));
        $this->assertFalse($this->validate(["sewer", ""]));
        $this->assertFalse($this->validate(["sewer", 123]));
        $this->assertFalse($this->validate(["sewer", "Invalid"]));
    }

    public function test_walls_valid_data_success(): void {
        $this->assertTrue($this->validate(["walls", $this->options["walls"][0]]));
    }

    public function test_walls_invalid_data_failure(): void {
        $this->assertFalse($this->validate(["walls", null]));
        $this->assertFalse($this->validate(["walls", ""]));
        $this->assertFalse($this->validate(["walls", 123]));
        $this->assertFalse($this->validate(["walls", "Invalid"]));
    }

    public function test_condition_valid_data_success(): void {
        $this->assertTrue($this->validate(["condition", $this->options["condition"][0]]));
    }

    public function test_condition_invalid_data_failure(): void {
        $this->assertFalse($this->validate(["condition", null]));
        $this->assertFalse($this->validate(["condition", ""]));
        $this->assertFalse($this->validate(["condition", 123]));
        $this->assertFalse($this->validate(["condition", "Invalid"]));
    }

    public function test_roof_valid_data_success(): void {
        $this->assertTrue($this->validate(["roof", $this->options["roof"][0]]));
    }

    public function test_roof_invalid_data_failure(): void {
        $this->assertFalse($this->validate(["roof", null]));
        $this->assertFalse($this->validate(["roof", ""]));
        $this->assertFalse($this->validate(["roof", 123]));
        $this->assertFalse($this->validate(["roof", "Invalid"]));
    }

    public function test_floor_valid_data_success(): void {
        $this->assertTrue($this->validate(["floor", $this->options["floor"][0]]));
    }

    public function test_floor_invalid_data_failure(): void {
        $this->assertFalse($this->validate(["floor", null]));
        $this->assertFalse($this->validate(["floor", ""]));
        $this->assertFalse($this->validate(["floor", 123]));
        $this->assertFalse($this->validate(["floor", "Invalid"]));
    }

    public function test_level_count_valid_data_success(): void {
        $this->assertTrue($this->validate(["level_count", 1], ["level_count", 100]));
    }

    public function test_level_count_invalid_data_failure(): void {
        $this->assertFalse($this->validate(["level_count", null]));
        $this->assertFalse($this->validate(["level_count", ""]));
        $this->assertFalse($this->validate(["level_count", -1]));
        $this->assertFalse($this->validate(["level_count", 0]));
        $this->assertFalse($this->validate(["level_count", 0.99]));
        $this->assertFalse($this->validate(["level_count", 101]));
    }

    public function test_area_valid_data_success(): void {
        $this->assertTrue($this->validate(["area", 1], ["kitchen_area", 1]));
        $this->assertTrue($this->validate(["area", 10000], ["kitchen_area", 1]));
    }

    public function test_area_invalid_data_failure(): void {
        $this->assertFalse($this->validate(["area", null],  ["kitchen_area", null]));
        $this->assertFalse($this->validate(["area", ""],    ["kitchen_area", ""]));
        $this->assertFalse($this->validate(["area", -1],    ["kitchen_area", -1]));
        $this->assertFalse($this->validate(["area", 0],     ["kitchen_area", 0]));
        $this->assertFalse($this->validate(["area", 1.01], ["kitchen_area", 1]));
        $this->assertFalse($this->validate(["area", 10001], ["kitchen_area", 1]));
    }

    public function test_kitchen_area_valid_data_success(): void {
        $this->assertTrue($this->validate(["area", 10000], ["kitchen_area", 1]));
        $this->assertTrue($this->validate(["area", 10000], ["kitchen_area", 10000]));
    }

    public function test_kitchen_area_invalid_data_failure(): void {
        $this->assertFalse($this->validate(["area", 10000], ["kitchen_area", null]));
        $this->assertFalse($this->validate(["area", 10000], ["kitchen_area", ""]));
        $this->assertFalse($this->validate(["area", 10000], ["kitchen_area", -1]));
        $this->assertFalse($this->validate(["area", 10000], ["kitchen_area", 0]));
        $this->assertFalse($this->validate(["area", 10000], ["kitchen_area", 0.99]));
        $this->assertFalse($this->validate(["area", 10000], ["kitchen_area", 10001]));
        $this->assertFalse($this->validate(["area", 1], ["kitchen_area", 2]));
        $this->assertFalse($this->validate(["area", 9999], ["kitchen_area", 10000]));
    }

    public function test_hot_water_valid_data_success(): void {
        $this->assertTrue($this->validate(["hot_water", $this->options["hot_water"][0]]));
    }

    public function test_hot_water_invalid_data_failure(): void {
        $this->assertFalse($this->validate(["hot_water", null]));
        $this->assertFalse($this->validate(["hot_water", ""]));
        $this->assertFalse($this->validate(["hot_water", 123]));
        $this->assertFalse($this->validate(["hot_water", "Invalid"]));
    }

    public function test_heating_valid_data_success(): void {
        $this->assertTrue($this->validate(["heating", $this->options["heating"][0]]));
    }

    public function test_heating_invalid_data_failure(): void {
        $this->assertFalse($this->validate(["heating", null]));
        $this->assertFalse($this->validate(["heating", ""]));
        $this->assertFalse($this->validate(["heating", 123]));
        $this->assertFalse($this->validate(["heating", "Invalid"]));
    }

    public function test_bath_valid_data_success(): void {
        $this->assertTrue($this->validate(["bath", $this->options["bath"][0]]));
    }

    public function test_bath_invalid_data_failure(): void {
        $this->assertFalse($this->validate(["bath", null]));
        $this->assertFalse($this->validate(["bath", ""]));
        $this->assertFalse($this->validate(["bath", 123]));
        $this->assertFalse($this->validate(["bath", "Invalid"]));
    }

    public function test_bathroom_valid_data_success(): void {
        $this->assertTrue($this->validate(["bathroom", $this->options["bathroom"][0]]));
    }

    public function test_bathroom_invalid_data_failure(): void {
        $this->assertFalse($this->validate(["bathroom", null]));
        $this->assertFalse($this->validate(["bathroom", ""]));
        $this->assertFalse($this->validate(["bathroom", 123]));
        $this->assertFalse($this->validate(["bathroom", "Invalid"]));
    }

    public function test_room_count_valid_data_success(): void {
        $this->assertTrue($this->validate(["room_count", 1], ["room_count", 100]));
    }

    public function test_room_count_invalid_data_failure(): void {
        $this->assertFalse($this->validate(["room_count", null]));
        $this->assertFalse($this->validate(["room_count", ""]));
        $this->assertFalse($this->validate(["room_count", -1]));
        $this->assertFalse($this->validate(["room_count", 0]));
        $this->assertFalse($this->validate(["room_count", 1.99]));
        $this->assertFalse($this->validate(["room_count", 101]));
    }

    public function test_land_area_valid_data_success(): void {
        $this->assertTrue($this->validate(["land_area", 1], ["land_area", 9999]));
    }

    public function test_land_area_invalid_data_failure(): void {
        $this->assertFalse($this->validate(["land_area", null]));
        $this->assertFalse($this->validate(["land_area", ""]));
        $this->assertFalse($this->validate(["land_area", -1]));
        $this->assertFalse($this->validate(["land_area", 0]));
        $this->assertFalse($this->validate(["land_area", 1.99]));
        $this->assertFalse($this->validate(["land_area", 10001]));
    }

    public function test_has_garage_valid_data_success(): void {
        $this->assertTrue($this->validate(["has_garage", true]));
        $this->assertTrue($this->validate(["has_garage", false]));
        $this->assertTrue($this->validate(["has_garage", 1]));
        $this->assertTrue($this->validate(["has_garage", 0]));
        $this->assertTrue($this->validate(["has_garage", "1"]));
        $this->assertTrue($this->validate(["has_garage", "0"]));
    }

    public function test_has_garage_invalid_data_failure(): void {
        $this->assertFalse($this->validate(["has_garage", null]));
        $this->assertFalse($this->validate(["has_garage", ""]));
        $this->assertFalse($this->validate(["has_garage", -1]));
        $this->assertFalse($this->validate(["has_garage", "asdasdasd"]));
        $this->assertFalse($this->validate(["has_garage", "on"]));
        $this->assertFalse($this->validate(["has_garage", "off"]));
        $this->assertFalse($this->validate(["has_garage", "yes"]));
        $this->assertFalse($this->validate(["has_garage", "no"]));
    }
}
