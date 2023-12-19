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

class UpdateApartmentValidationTest extends ValidationTestCase {

    use RefreshDatabase;

    private array $options;

    public function setUp(): void {
        parent::setUp();
        $this->seed(ApartmentOptionsSeeder::class);
        $this->rules = (new UpdateApartmentRequest())->rules();
        $this->options = app()->make(GetOptions::class)->run(Apartment::class);
    }

    public function test_has_water_valid_data_success(): void {
        $this->assertTrue($this->validate(["has_water", true]));
        $this->assertTrue($this->validate(["has_water", false]));
        $this->assertTrue($this->validate(["has_water", 1]));
        $this->assertTrue($this->validate(["has_water", 0]));
        $this->assertTrue($this->validate(["has_water", "1"]));
        $this->assertTrue($this->validate(["has_water", "0"]));
    }

    public function test_has_water_invalid_data_failure(): void {
        $this->assertFalse($this->validate(["has_water", null]));
        $this->assertFalse($this->validate(["has_water", ""]));
        $this->assertFalse($this->validate(["has_water", -1]));
        $this->assertFalse($this->validate(["has_water", "asdasdasd"]));
        $this->assertFalse($this->validate(["has_water", "on"]));
        $this->assertFalse($this->validate(["has_water", "off"]));
        $this->assertFalse($this->validate(["has_water", "yes"]));
        $this->assertFalse($this->validate(["has_water", "no"]));
    }

    public function test_has_gas_valid_data_success(): void {
        $this->assertTrue($this->validate(["has_gas", true]));
        $this->assertTrue($this->validate(["has_gas", false]));
        $this->assertTrue($this->validate(["has_gas", 1]));
        $this->assertTrue($this->validate(["has_gas", 0]));
        $this->assertTrue($this->validate(["has_gas", "1"]));
        $this->assertTrue($this->validate(["has_gas", "0"]));
    }

    public function test_has_gas_invalid_data_failure(): void {
        $this->assertFalse($this->validate(["has_gas", null]));
        $this->assertFalse($this->validate(["has_gas", ""]));
        $this->assertFalse($this->validate(["has_gas", -1]));
        $this->assertFalse($this->validate(["has_gas", "asdasdasd"]));
        $this->assertFalse($this->validate(["has_gas", "on"]));
        $this->assertFalse($this->validate(["has_gas", "off"]));
        $this->assertFalse($this->validate(["has_gas", "yes"]));
        $this->assertFalse($this->validate(["has_gas", "no"]));
    }

    public function test_has_electricity_valid_data_success(): void {
        $this->assertTrue($this->validate(["has_electricity", true]));
        $this->assertTrue($this->validate(["has_electricity", false]));
        $this->assertTrue($this->validate(["has_electricity", 1]));
        $this->assertTrue($this->validate(["has_electricity", 0]));
        $this->assertTrue($this->validate(["has_electricity", "1"]));
        $this->assertTrue($this->validate(["has_electricity", "0"]));
    }

    public function test_has_electricity_invalid_data_failure(): void {
        $this->assertFalse($this->validate(["has_electricity", null]));
        $this->assertFalse($this->validate(["has_electricity", ""]));
        $this->assertFalse($this->validate(["has_electricity", -1]));
        $this->assertFalse($this->validate(["has_electricity", "asdasdasd"]));
        $this->assertFalse($this->validate(["has_electricity", "on"]));
        $this->assertFalse($this->validate(["has_electricity", "off"]));
        $this->assertFalse($this->validate(["has_electricity", "yes"]));
        $this->assertFalse($this->validate(["has_electricity", "no"]));
    }

    public function test_has_sewer_valid_data_success(): void {
        $this->assertTrue($this->validate(["has_sewer", true]));
        $this->assertTrue($this->validate(["has_sewer", false]));
        $this->assertTrue($this->validate(["has_sewer", 1]));
        $this->assertTrue($this->validate(["has_sewer", 0]));
        $this->assertTrue($this->validate(["has_sewer", "1"]));
        $this->assertTrue($this->validate(["has_sewer", "0"]));
    }

    public function test_has_sewer_invalid_data_failure(): void {
        $this->assertFalse($this->validate(["has_sewer", null]));
        $this->assertFalse($this->validate(["has_sewer", ""]));
        $this->assertFalse($this->validate(["has_sewer", -1]));
        $this->assertFalse($this->validate(["has_sewer", "asdasdasd"]));
        $this->assertFalse($this->validate(["has_sewer", "on"]));
        $this->assertFalse($this->validate(["has_sewer", "off"]));
        $this->assertFalse($this->validate(["has_sewer", "yes"]));
        $this->assertFalse($this->validate(["has_sewer", "no"]));
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

    public function test_walls_valid_data_success(): void {
        $this->assertTrue($this->validate(["walls", $this->options["walls"][0]]));
    }

    public function test_walls_invalid_data_failure(): void {
        $this->assertFalse($this->validate(["walls", null]));
        $this->assertFalse($this->validate(["walls", ""]));
        $this->assertFalse($this->validate(["walls", 123]));
        $this->assertFalse($this->validate(["walls", "Invalid"]));
    }

    public function test_ceiling_valid_data_success(): void {
        $this->assertTrue($this->validate(["ceiling", 1.51]));
        $this->assertTrue($this->validate(["ceiling", 3.1234]));
        $this->assertTrue($this->validate(["ceiling", 1.5555555]));
        $this->assertTrue($this->validate(["ceiling", 4.00]));
        $this->assertTrue($this->validate(["ceiling", 5]));
    }

    public function test_ceiling_invalid_data_failure(): void {
        $this->assertFalse($this->validate(["ceiling", null]));
        $this->assertFalse($this->validate(["ceiling", ""]));
        $this->assertFalse($this->validate(["ceiling", -1]));
        $this->assertFalse($this->validate(["ceiling", 0]));
        $this->assertFalse($this->validate(["ceiling", 1]));
        $this->assertFalse($this->validate(["ceiling", 1.499]));
        $this->assertFalse($this->validate(["ceiling", 1.5]));
        $this->assertFalse($this->validate(["ceiling", 5.01]));
        $this->assertFalse($this->validate(["ceiling", 6]));
    }

    public function test_level_valid_data_success(): void {
        $this->assertTrue($this->validate(["level", 1], ["level_count", 100]));
        $this->assertTrue($this->validate(["level", 100], ["level_count", 100]));
    }

    public function test_level_invalid_data_failure(): void {
        $this->assertFalse($this->validate(["level", null], ["level_count", 100]));
        $this->assertFalse($this->validate(["level", ""], ["level_count", 100]));
        $this->assertFalse($this->validate(["level", -1], ["level_count", 100]));
        $this->assertFalse($this->validate(["level", 0], ["level_count", 100]));
        $this->assertFalse($this->validate(["level", 101], ["level_count", 100]));
        $this->assertFalse($this->validate(["level", 5], ["level_count", 4]));
        $this->assertFalse($this->validate(["level", 100], ["level_count", 99]));
    }

    public function test_level_count_valid_data_success(): void {
        $this->assertTrue($this->validate(["level", 1], ["level_count", 1]));
        $this->assertTrue($this->validate(["level", 1], ["level_count", 100]));
    }

    public function test_level_count_invalid_data_failure(): void {
        $this->assertFalse($this->validate(["level", null], ["level_count", null]));
        $this->assertFalse($this->validate(["level", ""], ["level_count", ""]));
        $this->assertFalse($this->validate(["level", -1], ["level_count", -1]));
        $this->assertFalse($this->validate(["level", 0], ["level_count", 0]));
        $this->assertFalse($this->validate(["level", 1], ["level_count", 101]));
    }

    public function test_has_heating_valid_data_success(): void {
        $this->assertTrue($this->validate(["has_heating", true]));
        $this->assertTrue($this->validate(["has_heating", false]));
        $this->assertTrue($this->validate(["has_heating", 1]));
        $this->assertTrue($this->validate(["has_heating", 0]));
        $this->assertTrue($this->validate(["has_heating", "1"]));
        $this->assertTrue($this->validate(["has_heating", "0"]));
    }

    public function test_has_heating_invalid_data_failure(): void {
        $this->assertFalse($this->validate(["has_heating", null]));
        $this->assertFalse($this->validate(["has_heating", ""]));
        $this->assertFalse($this->validate(["has_heating", -1]));
        $this->assertFalse($this->validate(["has_heating", "asdasdasd"]));
        $this->assertFalse($this->validate(["has_heating", "on"]));
        $this->assertFalse($this->validate(["has_heating", "off"]));
        $this->assertFalse($this->validate(["has_heating", "yes"]));
        $this->assertFalse($this->validate(["has_heating", "no"]));
    }

    public function test_has_hot_water_valid_data_success(): void {
        $this->assertTrue($this->validate(["has_hot_water", true]));
        $this->assertTrue($this->validate(["has_hot_water", false]));
        $this->assertTrue($this->validate(["has_hot_water", 1]));
        $this->assertTrue($this->validate(["has_hot_water", 0]));
        $this->assertTrue($this->validate(["has_hot_water", "1"]));
        $this->assertTrue($this->validate(["has_hot_water", "0"]));
    }

    public function test_has_hot_water_invalid_data_failure(): void {
        $this->assertFalse($this->validate(["has_hot_water", null]));
        $this->assertFalse($this->validate(["has_hot_water", ""]));
        $this->assertFalse($this->validate(["has_hot_water", -1]));
        $this->assertFalse($this->validate(["has_hot_water", "asdasdasd"]));
        $this->assertFalse($this->validate(["has_hot_water", "on"]));
        $this->assertFalse($this->validate(["has_hot_water", "off"]));
        $this->assertFalse($this->validate(["has_hot_water", "yes"]));
        $this->assertFalse($this->validate(["has_hot_water", "no"]));
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

    public function test_area_valid_data_success(): void {
        $this->assertTrue($this->validate(["area", 1]));
        $this->assertTrue($this->validate(["area", 10000]));
    }

    public function test_area_invalid_data_failure(): void {
        $this->assertFalse($this->validate(["area", null]));
        $this->assertFalse($this->validate(["area", ""]));
        $this->assertFalse($this->validate(["area", -1]));
        $this->assertFalse($this->validate(["area", 0]));
        $this->assertFalse($this->validate(["area", 10001]));
    }

    public function test_room_count_valid_data_success(): void {
        $this->assertTrue($this->validate(["room_count", 1]));
        $this->assertTrue($this->validate(["room_count", 100]));
    }

    public function test_room_count_invalid_data_failure(): void {
        $this->assertFalse($this->validate(["room_count", null]));
        $this->assertFalse($this->validate(["room_count", ""]));
        $this->assertFalse($this->validate(["room_count", -1]));
        $this->assertFalse($this->validate(["room_count", 0]));
        $this->assertFalse($this->validate(["room_count", 101]));
    }

    public function test_has_loggia_valid_data_success(): void {
        $this->assertTrue($this->validate(["has_loggia", true]));
        $this->assertTrue($this->validate(["has_loggia", false]));
        $this->assertTrue($this->validate(["has_loggia", 1]));
        $this->assertTrue($this->validate(["has_loggia", 0]));
        $this->assertTrue($this->validate(["has_loggia", "1"]));
        $this->assertTrue($this->validate(["has_loggia", "0"]));
    }

    public function test_has_loggia_invalid_data_failure(): void {
        $this->assertFalse($this->validate(["has_loggia", null]));
        $this->assertFalse($this->validate(["has_loggia", ""]));
        $this->assertFalse($this->validate(["has_loggia", -1]));
        $this->assertFalse($this->validate(["has_loggia", "asdasdasd"]));
        $this->assertFalse($this->validate(["has_loggia", "on"]));
        $this->assertFalse($this->validate(["has_loggia", "off"]));
        $this->assertFalse($this->validate(["has_loggia", "yes"]));
        $this->assertFalse($this->validate(["has_loggia", "no"]));
    }

    public function test_has_balcony_valid_data_success(): void {
        $this->assertTrue($this->validate(["has_balcony", true]));
        $this->assertTrue($this->validate(["has_balcony", false]));
        $this->assertTrue($this->validate(["has_balcony", 1]));
        $this->assertTrue($this->validate(["has_balcony", 0]));
        $this->assertTrue($this->validate(["has_balcony", "1"]));
        $this->assertTrue($this->validate(["has_balcony", "0"]));
    }

    public function test_has_balcony_invalid_data_failure(): void {
        $this->assertFalse($this->validate(["has_balcony", null]));
        $this->assertFalse($this->validate(["has_balcony", ""]));
        $this->assertFalse($this->validate(["has_balcony", -1]));
        $this->assertFalse($this->validate(["has_balcony", "asdasdasd"]));
        $this->assertFalse($this->validate(["has_balcony", "on"]));
        $this->assertFalse($this->validate(["has_balcony", "off"]));
        $this->assertFalse($this->validate(["has_balcony", "yes"]));
        $this->assertFalse($this->validate(["has_balcony", "no"]));
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

    public function test_has_garbage_chute_valid_data_success(): void {
        $this->assertTrue($this->validate(["has_garbage_chute", true]));
        $this->assertTrue($this->validate(["has_garbage_chute", false]));
        $this->assertTrue($this->validate(["has_garbage_chute", 1]));
        $this->assertTrue($this->validate(["has_garbage_chute", 0]));
        $this->assertTrue($this->validate(["has_garbage_chute", "1"]));
        $this->assertTrue($this->validate(["has_garbage_chute", "0"]));
    }

    public function test_has_garbage_chute_invalid_data_failure(): void {
        $this->assertFalse($this->validate(["has_garbage_chute", null]));
        $this->assertFalse($this->validate(["has_garbage_chute", ""]));
        $this->assertFalse($this->validate(["has_garbage_chute", -1]));
        $this->assertFalse($this->validate(["has_garbage_chute", "asdasdasd"]));
        $this->assertFalse($this->validate(["has_garbage_chute", "on"]));
        $this->assertFalse($this->validate(["has_garbage_chute", "off"]));
        $this->assertFalse($this->validate(["has_garbage_chute", "yes"]));
        $this->assertFalse($this->validate(["has_garbage_chute", "no"]));
    }

    public function test_has_elevator_valid_data_success(): void {
        $this->assertTrue($this->validate(["has_elevator", true]));
        $this->assertTrue($this->validate(["has_elevator", false]));
        $this->assertTrue($this->validate(["has_elevator", 1]));
        $this->assertTrue($this->validate(["has_elevator", 0]));
        $this->assertTrue($this->validate(["has_elevator", "1"]));
        $this->assertTrue($this->validate(["has_elevator", "0"]));
    }

    public function test_has_elevator_invalid_data_failure(): void {
        $this->assertFalse($this->validate(["has_elevator", null]));
        $this->assertFalse($this->validate(["has_elevator", ""]));
        $this->assertFalse($this->validate(["has_elevator", -1]));
        $this->assertFalse($this->validate(["has_elevator", "asdasdasd"]));
        $this->assertFalse($this->validate(["has_elevator", "on"]));
        $this->assertFalse($this->validate(["has_elevator", "off"]));
        $this->assertFalse($this->validate(["has_elevator", "yes"]));
        $this->assertFalse($this->validate(["has_elevator", "no"]));
    }

    public function test_is_corner_valid_data_success(): void {
        $this->assertTrue($this->validate(["is_corner", true]));
        $this->assertTrue($this->validate(["is_corner", false]));
        $this->assertTrue($this->validate(["is_corner", 1]));
        $this->assertTrue($this->validate(["is_corner", 0]));
        $this->assertTrue($this->validate(["is_corner", "1"]));
        $this->assertTrue($this->validate(["is_corner", "0"]));
    }

    public function test_is_corner_invalid_data_failure(): void {
        $this->assertFalse($this->validate(["is_corner", null]));
        $this->assertFalse($this->validate(["is_corner", ""]));
        $this->assertFalse($this->validate(["is_corner", -1]));
        $this->assertFalse($this->validate(["is_corner", "asdasdasd"]));
        $this->assertFalse($this->validate(["is_corner", "on"]));
        $this->assertFalse($this->validate(["is_corner", "off"]));
        $this->assertFalse($this->validate(["is_corner", "yes"]));
        $this->assertFalse($this->validate(["is_corner", "no"]));
    }
}
