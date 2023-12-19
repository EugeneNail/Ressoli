<?php

namespace Tests\Unit;

use App\Actions\GetOptions;
use App\Http\Requests\StoreHouseRequest;
use App\Models\House;
use Database\Seeders\HouseOptionsSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Validator;

class StoreHouseValidationTest extends RequestValidationTest {

    use RefreshDatabase;

    private array $options;

    public function setUp(): void {
        parent::setUp();
        $this->seed(HouseOptionsSeeder::class);
        $this->rules = (new StoreHouseRequest())->rules();
        $this->options = app()->make(GetOptions::class)->run(House::class);
    }

    public function test_water_valid_data_success(): void {

        $this->assertTrue($this->validateField("water", $this->options["water"][0]));
    }

    public function test_water_invalid_data_failure(): void {
        $this->assertFalse($this->validateField("water", null));
        $this->assertFalse($this->validateField("water", ""));
        $this->assertFalse($this->validateField("water", 123));
        $this->assertFalse($this->validateField("water", "Invalid"));
    }

    public function test_gas_valid_data_success(): void {
        $this->assertTrue($this->validateField("gas", $this->options["gas"][0]));
    }

    public function test_gas_invalid_data_failure(): void {
        $this->assertFalse($this->validateField("gas", null));
        $this->assertFalse($this->validateField("gas", ""));
        $this->assertFalse($this->validateField("gas", 123));
        $this->assertFalse($this->validateField("gas", "Invalid"));
    }

    public function test_electricity_valid_data_success(): void {
        $this->assertTrue($this->validateField("electricity", $this->options["electricity"][0]));
    }

    public function test_electricity_invalid_data_failure(): void {
        $this->assertFalse($this->validateField("electricity", null));
        $this->assertFalse($this->validateField("electricity", ""));
        $this->assertFalse($this->validateField("electricity", 123));
        $this->assertFalse($this->validateField("electricity", "Invalid"));
    }

    public function test_sewer_valid_data_success(): void {
        $this->assertTrue($this->validateField("sewer", $this->options["sewer"][0]));
    }

    public function test_sewer_invalid_data_failure(): void {
        $this->assertFalse($this->validateField("sewer", null));
        $this->assertFalse($this->validateField("sewer", ""));
        $this->assertFalse($this->validateField("sewer", 123));
        $this->assertFalse($this->validateField("sewer", "Invalid"));
    }

    public function test_walls_valid_data_success(): void {
        $this->assertTrue($this->validateField("walls", $this->options["walls"][0]));
    }

    public function test_walls_invalid_data_failure(): void {
        $this->assertFalse($this->validateField("walls", null));
        $this->assertFalse($this->validateField("walls", ""));
        $this->assertFalse($this->validateField("walls", 123));
        $this->assertFalse($this->validateField("walls", "Invalid"));
    }

    public function test_condition_valid_data_success(): void {
        $this->assertTrue($this->validateField("condition", $this->options["condition"][0]));
    }

    public function test_condition_invalid_data_failure(): void {
        $this->assertFalse($this->validateField("condition", null));
        $this->assertFalse($this->validateField("condition", ""));
        $this->assertFalse($this->validateField("condition", 123));
        $this->assertFalse($this->validateField("condition", "Invalid"));
    }

    public function test_roof_valid_data_success(): void {
        $this->assertTrue($this->validateField("roof", $this->options["roof"][0]));
    }

    public function test_roof_invalid_data_failure(): void {
        $this->assertFalse($this->validateField("roof", null));
        $this->assertFalse($this->validateField("roof", ""));
        $this->assertFalse($this->validateField("roof", 123));
        $this->assertFalse($this->validateField("roof", "Invalid"));
    }

    public function test_floor_valid_data_success(): void {
        $this->assertTrue($this->validateField("floor", $this->options["floor"][0]));
    }

    public function test_floor_invalid_data_failure(): void {
        $this->assertFalse($this->validateField("floor", null));
        $this->assertFalse($this->validateField("floor", ""));
        $this->assertFalse($this->validateField("floor", 123));
        $this->assertFalse($this->validateField("floor", "Invalid"));
    }

    public function test_level_count_valid_data_success(): void {
        $this->assertTrue($this->validateField("level_count", 1));
        $this->assertTrue($this->validateField("level_count", 100));
    }

    public function test_level_count_invalid_data_failure(): void {
        $this->assertFalse($this->validateField("level_count", null));
        $this->assertFalse($this->validateField("level_count", ""));
        $this->assertFalse($this->validateField("level_count", -1));
        $this->assertFalse($this->validateField("level_count", 0));
        $this->assertFalse($this->validateField("level_count", 101));
    }

    public function test_area_valid_data_success(): void {
        $this->assertTrue($this->validateMultipleFields(["area", 1],     ["kitchen_area", 1]));
        $this->assertTrue($this->validateMultipleFields(["area", 10000], ["kitchen_area", 1]));
    }

    public function test_area_invalid_data_failure(): void {
        $this->assertFalse($this->validateMultipleFields(["area", null],  ["kitchen_area", null]));
        $this->assertFalse($this->validateMultipleFields(["area", ""],    ["kitchen_area", ""]));
        $this->assertFalse($this->validateMultipleFields(["area", -1],    ["kitchen_area", -1]));
        $this->assertFalse($this->validateMultipleFields(["area", 0],     ["kitchen_area", 0]));
        $this->assertFalse($this->validateMultipleFields(["area", 10001], ["kitchen_area", 1]));
    }

    public function test_kitchen_area_valid_data_success(): void {
        $this->assertTrue($this->validateMultipleFields(["area", 10000],     ["kitchen_area", 1]));
        $this->assertTrue($this->validateMultipleFields(["area", 10000],     ["kitchen_area", 10000]));
    }

    public function test_kitchen_area_invalid_data_failure(): void {
        $this->assertFalse($this->validateMultipleFields(["area", 10000],     ["kitchen_area", null]));
        $this->assertFalse($this->validateMultipleFields(["area", 10000],     ["kitchen_area", ""]));
        $this->assertFalse($this->validateMultipleFields(["area", 10000],     ["kitchen_area", -1]));
        $this->assertFalse($this->validateMultipleFields(["area", 10000],     ["kitchen_area", 0]));
        $this->assertFalse($this->validateMultipleFields(["area", 10000],     ["kitchen_area", 10001]));
        $this->assertFalse($this->validateMultipleFields(["area", 1],         ["kitchen_area", 2]));
        $this->assertFalse($this->validateMultipleFields(["area", 9999],      ["kitchen_area", 10000]));
    }

    public function test_hot_water_valid_data_success(): void {
        $this->assertTrue($this->validateField("hot_water", $this->options["hot_water"][0]));
    }

    public function test_hot_water_invalid_data_failure(): void {
        $this->assertFalse($this->validateField("hot_water", null));
        $this->assertFalse($this->validateField("hot_water", ""));
        $this->assertFalse($this->validateField("hot_water", 123));
        $this->assertFalse($this->validateField("hot_water", "Invalid"));
    }

    public function test_heating_valid_data_success(): void {
        $this->assertTrue($this->validateField("heating", $this->options["heating"][0]));
    }

    public function test_heating_invalid_data_failure(): void {
        $this->assertFalse($this->validateField("heating", null));
        $this->assertFalse($this->validateField("heating", ""));
        $this->assertFalse($this->validateField("heating", 123));
        $this->assertFalse($this->validateField("heating", "Invalid"));
    }

    public function test_bath_valid_data_success(): void {
        $this->assertTrue($this->validateField("bath", $this->options["bath"][0]));
    }

    public function test_bath_invalid_data_failure(): void {
        $this->assertFalse($this->validateField("bath", null));
        $this->assertFalse($this->validateField("bath", ""));
        $this->assertFalse($this->validateField("bath", 123));
        $this->assertFalse($this->validateField("bath", "Invalid"));
    }

    public function test_bathroom_valid_data_success(): void {
        $this->assertTrue($this->validateField("bathroom", $this->options["bathroom"][0]));
    }

    public function test_bathroom_invalid_data_failure(): void {
        $this->assertFalse($this->validateField("bathroom", null));
        $this->assertFalse($this->validateField("bathroom", ""));
        $this->assertFalse($this->validateField("bathroom", 123));
        $this->assertFalse($this->validateField("bathroom", "Invalid"));
    }

    public function test_room_count_valid_data_success(): void {
        $this->assertTrue($this->validateField("room_count", 1));
        $this->assertTrue($this->validateField("room_count", 100));
    }

    public function test_room_count_invalid_data_failure(): void {
        $this->assertFalse($this->validateField("room_count", null));
        $this->assertFalse($this->validateField("room_count", ""));
        $this->assertFalse($this->validateField("room_count", -1));
        $this->assertFalse($this->validateField("room_count", 0));
        $this->assertFalse($this->validateField("room_count", 101));
    }

    public function test_land_area_valid_data_success(): void {
        $this->assertTrue($this->validateField("land_area", 1));
        $this->assertTrue($this->validateField("land_area", 9999));
    }

    public function test_land_area_invalid_data_failure(): void {
        $this->assertFalse($this->validateField("land_area", null));
        $this->assertFalse($this->validateField("land_area", ""));
        $this->assertFalse($this->validateField("land_area", -1));
        $this->assertFalse($this->validateField("land_area", 0));
        $this->assertFalse($this->validateField("land_area", 10001));
    }

    public function test_has_garage_valid_data_success(): void {
        $this->assertTrue($this->validateField("has_garage", true));
        $this->assertTrue($this->validateField("has_garage", false));
        $this->assertTrue($this->validateField("has_garage", 1));
        $this->assertTrue($this->validateField("has_garage", 0));
        $this->assertTrue($this->validateField("has_garage", "1"));
        $this->assertTrue($this->validateField("has_garage", "0"));
    }

    public function test_has_garage_invalid_data_failure(): void {
        $this->assertFalse($this->validateField("has_garage", null));
        $this->assertFalse($this->validateField("has_garage", ""));
        $this->assertFalse($this->validateField("has_garage", -1));
        $this->assertFalse($this->validateField("has_garage", "asdasdasd"));
        $this->assertFalse($this->validateField("has_garage", "on"));
        $this->assertFalse($this->validateField("has_garage", "off"));
        $this->assertFalse($this->validateField("has_garage", "yes"));
        $this->assertFalse($this->validateField("has_garage", "no"));
    }
}
