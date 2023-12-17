<?php

namespace Tests\Unit;

use App\Actions\GetOptions;
use App\Http\Requests\StoreApartmentRequest;
use App\Http\Requests\UpdateApartmentRequest;
use App\Models\Apartment;
use Database\Seeders\ApartmentOptionsSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Validator;
use PHPUnit\Framework\TestCase;

class UpdateApartmentValidationTest extends RequestValidationTest {

    use RefreshDatabase;

    private array $options;

    public function setUp(): void {
        parent::setUp();
        $this->seed(ApartmentOptionsSeeder::class);
        $this->rules = (new UpdateApartmentRequest())->rules();
        $this->options = app()->make(GetOptions::class)->run(Apartment::class);
    }

    public function test_has_water_valid_data_success(): void {
        $this->assertTrue($this->validateField("has_water", 1));
        $this->assertTrue($this->validateField("has_water", 0));
        $this->assertTrue($this->validateField("has_water", "1"));
        $this->assertTrue($this->validateField("has_water", "0"));
        $this->assertTrue($this->validateField("has_water", null));
        $this->assertTrue($this->validateField("has_water", ""));
    }

    public function test_has_water_invalid_data_failure(): void {
        $this->assertFalse($this->validateField("has_water", -1));
        $this->assertFalse($this->validateField("has_water", "asdasdasd"));
        $this->assertFalse($this->validateField("has_water", "on"));
        $this->assertFalse($this->validateField("has_water", "off"));
        $this->assertFalse($this->validateField("has_water", "yes"));
        $this->assertFalse($this->validateField("has_water", "no"));
    }

    public function test_has_gas_valid_data_success(): void {
        $this->assertTrue($this->validateField("has_gas", 1));
        $this->assertTrue($this->validateField("has_gas", 0));
        $this->assertTrue($this->validateField("has_gas", "1"));
        $this->assertTrue($this->validateField("has_gas", "0"));
        $this->assertTrue($this->validateField("has_gas", null));
        $this->assertTrue($this->validateField("has_gas", ""));
    }

    public function test_has_gas_invalid_data_failure(): void {
        $this->assertFalse($this->validateField("has_gas", -1));
        $this->assertFalse($this->validateField("has_gas", "asdasdasd"));
        $this->assertFalse($this->validateField("has_gas", "on"));
        $this->assertFalse($this->validateField("has_gas", "off"));
        $this->assertFalse($this->validateField("has_gas", "yes"));
        $this->assertFalse($this->validateField("has_gas", "no"));
    }

    public function test_has_electricity_valid_data_success(): void {
        $this->assertTrue($this->validateField("has_electricity", 1));
        $this->assertTrue($this->validateField("has_electricity", 0));
        $this->assertTrue($this->validateField("has_electricity", "1"));
        $this->assertTrue($this->validateField("has_electricity", "0"));
        $this->assertTrue($this->validateField("has_electricity", null));
        $this->assertTrue($this->validateField("has_electricity", ""));
    }

    public function test_has_electricity_invalid_data_failure(): void {
        $this->assertFalse($this->validateField("has_electricity", -1));
        $this->assertFalse($this->validateField("has_electricity", "asdasdasd"));
        $this->assertFalse($this->validateField("has_electricity", "on"));
        $this->assertFalse($this->validateField("has_electricity", "off"));
        $this->assertFalse($this->validateField("has_electricity", "yes"));
        $this->assertFalse($this->validateField("has_electricity", "no"));
    }

    public function test_has_sewer_valid_data_success(): void {
        $this->assertTrue($this->validateField("has_sewer", 1));
        $this->assertTrue($this->validateField("has_sewer", 0));
        $this->assertTrue($this->validateField("has_sewer", "1"));
        $this->assertTrue($this->validateField("has_sewer", "0"));
        $this->assertTrue($this->validateField("has_sewer", null));
        $this->assertTrue($this->validateField("has_sewer", ""));
    }

    public function test_has_sewer_invalid_data_failure(): void {
        $this->assertFalse($this->validateField("has_sewer", -1));
        $this->assertFalse($this->validateField("has_sewer", "asdasdasd"));
        $this->assertFalse($this->validateField("has_sewer", "on"));
        $this->assertFalse($this->validateField("has_sewer", "off"));
        $this->assertFalse($this->validateField("has_sewer", "yes"));
        $this->assertFalse($this->validateField("has_sewer", "no"));
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

    public function test_walls_valid_data_success(): void {
        $this->assertTrue($this->validateField("walls", $this->options["walls"][0]));
    }

    public function test_walls_invalid_data_failure(): void {
        $this->assertFalse($this->validateField("walls", null));
        $this->assertFalse($this->validateField("walls", ""));
        $this->assertFalse($this->validateField("walls", 123));
        $this->assertFalse($this->validateField("walls", "Invalid"));
    }

    public function test_ceiling_valid_data_success(): void {
        $this->assertTrue($this->validateField("ceiling", 1.51));
        $this->assertTrue($this->validateField("ceiling", 3.1234));
        $this->assertTrue($this->validateField("ceiling", 1.5555555));
        $this->assertTrue($this->validateField("ceiling", 4.00));
        $this->assertTrue($this->validateField("ceiling", 5));
    }

    public function test_ceiling_invalid_data_failure(): void {
        $this->assertFalse($this->validateField("ceiling", null));
        $this->assertFalse($this->validateField("ceiling", ""));
        $this->assertFalse($this->validateField("ceiling", -1));
        $this->assertFalse($this->validateField("ceiling", 0));
        $this->assertFalse($this->validateField("ceiling", 1));
        $this->assertFalse($this->validateField("ceiling", 1.499));
        $this->assertFalse($this->validateField("ceiling", 1.5));
        $this->assertFalse($this->validateField("ceiling", 5.01));
        $this->assertFalse($this->validateField("ceiling", 6));
    }

    public function test_level_valid_data_success(): void {
        $this->assertTrue($this->validateMultipleFields(["level", 1],   ["level_count", 100]));
        $this->assertTrue($this->validateMultipleFields(["level", 100], ["level_count", 100]));
    }

    public function test_level_invalid_data_failure(): void {
        $this->assertFalse($this->validateMultipleFields(["level", null], ["level_count", 100]));
        $this->assertFalse($this->validateMultipleFields(["level", ""],   ["level_count", 100]));
        $this->assertFalse($this->validateMultipleFields(["level", -1],   ["level_count", 100]));
        $this->assertFalse($this->validateMultipleFields(["level", 0],    ["level_count", 100]));
        $this->assertFalse($this->validateMultipleFields(["level", 101],  ["level_count", 100]));
        $this->assertFalse($this->validateMultipleFields(["level", 5],    ["level_count", 4]));
        $this->assertFalse($this->validateMultipleFields(["level", 100],  ["level_count", 99]));
    }

    public function test_level_count_valid_data_success(): void {
        $this->assertTrue($this->validateMultipleFields(["level", 1], ["level_count", 1]));
        $this->assertTrue($this->validateMultipleFields(["level", 1], ["level_count", 100]));
    }

    public function test_level_count_invalid_data_failure(): void {
        $this->assertFalse($this->validateMultipleFields(["level", null], ["level_count", null]));
        $this->assertFalse($this->validateMultipleFields(["level", ""],   ["level_count", ""]));
        $this->assertFalse($this->validateMultipleFields(["level", -1],   ["level_count", -1]));
        $this->assertFalse($this->validateMultipleFields(["level", 0],    ["level_count", 0]));
        $this->assertFalse($this->validateMultipleFields(["level", 1],    ["level_count", 101]));
    }

    public function test_has_heating_valid_data_success(): void {
        $this->assertTrue($this->validateField("has_heating", 1));
        $this->assertTrue($this->validateField("has_heating", 0));
        $this->assertTrue($this->validateField("has_heating", "1"));
        $this->assertTrue($this->validateField("has_heating", "0"));
        $this->assertTrue($this->validateField("has_heating", null));
        $this->assertTrue($this->validateField("has_heating", ""));
    }

    public function test_has_heating_invalid_data_failure(): void {
        $this->assertFalse($this->validateField("has_heating", -1));
        $this->assertFalse($this->validateField("has_heating", "asdasdasd"));
        $this->assertFalse($this->validateField("has_heating", "on"));
        $this->assertFalse($this->validateField("has_heating", "off"));
        $this->assertFalse($this->validateField("has_heating", "yes"));
        $this->assertFalse($this->validateField("has_heating", "no"));
    }

    public function test_has_hot_water_valid_data_success(): void {
        $this->assertTrue($this->validateField("has_hot_water", 1));
        $this->assertTrue($this->validateField("has_hot_water", 0));
        $this->assertTrue($this->validateField("has_hot_water", "1"));
        $this->assertTrue($this->validateField("has_hot_water", "0"));
        $this->assertTrue($this->validateField("has_hot_water", null));
        $this->assertTrue($this->validateField("has_hot_water", ""));
    }

    public function test_has_hot_water_invalid_data_failure(): void {
        $this->assertFalse($this->validateField("has_hot_water", -1));
        $this->assertFalse($this->validateField("has_hot_water", "asdasdasd"));
        $this->assertFalse($this->validateField("has_hot_water", "on"));
        $this->assertFalse($this->validateField("has_hot_water", "off"));
        $this->assertFalse($this->validateField("has_hot_water", "yes"));
        $this->assertFalse($this->validateField("has_hot_water", "no"));
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

    public function test_area_valid_data_success(): void {
        $this->assertTrue($this->validateField("area", 1));
        $this->assertTrue($this->validateField("area", 10000));
    }

    public function test_area_invalid_data_failure(): void {
        $this->assertFalse($this->validateField("area", null));
        $this->assertFalse($this->validateField("area", ""));
        $this->assertFalse($this->validateField("area", -1));
        $this->assertFalse($this->validateField("area", 0));
        $this->assertFalse($this->validateField("area", 10001));
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

    public function test_has_loggia_valid_data_success(): void {
        $this->assertTrue($this->validateField("has_loggia", 1));
        $this->assertTrue($this->validateField("has_loggia", 0));
        $this->assertTrue($this->validateField("has_loggia", "1"));
        $this->assertTrue($this->validateField("has_loggia", "0"));
        $this->assertTrue($this->validateField("has_loggia", null));
        $this->assertTrue($this->validateField("has_loggia", ""));
    }

    public function test_has_loggia_invalid_data_failure(): void {
        $this->assertFalse($this->validateField("has_loggia", -1));
        $this->assertFalse($this->validateField("has_loggia", "asdasdasd"));
        $this->assertFalse($this->validateField("has_loggia", "on"));
        $this->assertFalse($this->validateField("has_loggia", "off"));
        $this->assertFalse($this->validateField("has_loggia", "yes"));
        $this->assertFalse($this->validateField("has_loggia", "no"));
    }

    public function test_has_balcony_valid_data_success(): void {
        $this->assertTrue($this->validateField("has_balcony", 1));
        $this->assertTrue($this->validateField("has_balcony", 0));
        $this->assertTrue($this->validateField("has_balcony", "1"));
        $this->assertTrue($this->validateField("has_balcony", "0"));
        $this->assertTrue($this->validateField("has_balcony", null));
        $this->assertTrue($this->validateField("has_balcony", ""));
    }

    public function test_has_balcony_invalid_data_failure(): void {
        $this->assertFalse($this->validateField("has_balcony", -1));
        $this->assertFalse($this->validateField("has_balcony", "asdasdasd"));
        $this->assertFalse($this->validateField("has_balcony", "on"));
        $this->assertFalse($this->validateField("has_balcony", "off"));
        $this->assertFalse($this->validateField("has_balcony", "yes"));
        $this->assertFalse($this->validateField("has_balcony", "no"));
    }

    public function test_has_garage_valid_data_success(): void {
        $this->assertTrue($this->validateField("has_garage", 1));
        $this->assertTrue($this->validateField("has_garage", 0));
        $this->assertTrue($this->validateField("has_garage", "1"));
        $this->assertTrue($this->validateField("has_garage", "0"));
        $this->assertTrue($this->validateField("has_garage", null));
        $this->assertTrue($this->validateField("has_garage", ""));
    }

    public function test_has_garage_invalid_data_failure(): void {
        $this->assertFalse($this->validateField("has_garage", -1));
        $this->assertFalse($this->validateField("has_garage", "asdasdasd"));
        $this->assertFalse($this->validateField("has_garage", "on"));
        $this->assertFalse($this->validateField("has_garage", "off"));
        $this->assertFalse($this->validateField("has_garage", "yes"));
        $this->assertFalse($this->validateField("has_garage", "no"));
    }

    public function test_has_garbage_chute_valid_data_success(): void {
        $this->assertTrue($this->validateField("has_garbage_chute", 1));
        $this->assertTrue($this->validateField("has_garbage_chute", 0));
        $this->assertTrue($this->validateField("has_garbage_chute", "1"));
        $this->assertTrue($this->validateField("has_garbage_chute", "0"));
        $this->assertTrue($this->validateField("has_garbage_chute", null));
        $this->assertTrue($this->validateField("has_garbage_chute", ""));
    }

    public function test_has_garbage_chute_invalid_data_failure(): void {
        $this->assertFalse($this->validateField("has_garbage_chute", -1));
        $this->assertFalse($this->validateField("has_garbage_chute", "asdasdasd"));
        $this->assertFalse($this->validateField("has_garbage_chute", "on"));
        $this->assertFalse($this->validateField("has_garbage_chute", "off"));
        $this->assertFalse($this->validateField("has_garbage_chute", "yes"));
        $this->assertFalse($this->validateField("has_garbage_chute", "no"));
    }

    public function test_has_elevator_valid_data_success(): void {
        $this->assertTrue($this->validateField("has_elevator", 1));
        $this->assertTrue($this->validateField("has_elevator", 0));
        $this->assertTrue($this->validateField("has_elevator", "1"));
        $this->assertTrue($this->validateField("has_elevator", "0"));
        $this->assertTrue($this->validateField("has_elevator", null));
        $this->assertTrue($this->validateField("has_elevator", ""));
    }

    public function test_has_elevator_invalid_data_failure(): void {
        $this->assertFalse($this->validateField("has_elevator", -1));
        $this->assertFalse($this->validateField("has_elevator", "asdasdasd"));
        $this->assertFalse($this->validateField("has_elevator", "on"));
        $this->assertFalse($this->validateField("has_elevator", "off"));
        $this->assertFalse($this->validateField("has_elevator", "yes"));
        $this->assertFalse($this->validateField("has_elevator", "no"));
    }

    public function test_is_corner_valid_data_success(): void {
        $this->assertTrue($this->validateField("is_corner", 1));
        $this->assertTrue($this->validateField("is_corner", 0));
        $this->assertTrue($this->validateField("is_corner", "1"));
        $this->assertTrue($this->validateField("is_corner", "0"));
        $this->assertTrue($this->validateField("is_corner", null));
        $this->assertTrue($this->validateField("is_corner", ""));
    }

    public function test_is_corner_invalid_data_failure(): void {
        $this->assertFalse($this->validateField("is_corner", -1));
        $this->assertFalse($this->validateField("is_corner", "asdasdasd"));
        $this->assertFalse($this->validateField("is_corner", "on"));
        $this->assertFalse($this->validateField("is_corner", "off"));
        $this->assertFalse($this->validateField("is_corner", "yes"));
        $this->assertFalse($this->validateField("is_corner", "no"));
    }
}
