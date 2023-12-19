<?php

namespace Tests\Unit;

use App\Actions\GetOptions;
use App\Http\Requests\StoreLandParcelRequest;
use App\Models\LandParcel;
use Database\Seeders\LandParcelOptionsSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Validator;
use Tests\TestCase;

class StoreLandParcelValidationTest extends ValidationTestCase {

    use RefreshDatabase;

    private array $options;

    public function setUp(): void {
        parent::setUp();
        $this->seed(LandParcelOptionsSeeder::class);
        $this->rules = (new StoreLandParcelRequest())->rules();
        $this->options = app()->make(GetOptions::class)->run(LandParcel::class);
    }

    public function test_water_valid_data_success(): void {
        $this->assertTrue($this->validate(["water", $this->options["water"][0]]));
        $this->assertTrue($this->validate(["water", "None"]));
        $this->assertTrue($this->validate(["water", "On the boundary"]));
        $this->assertTrue($this->validate(["water", "Well"]));
    }

    public function test_water_invalid_data_failure(): void {
        $this->assertFalse($this->validate(["water", null]));
    }

    public function test_gas_valid_data_success(): void {
        $this->assertTrue($this->validate(["gas", $this->options["gas"][0]]));
    }

    public function test_gas_invalid_data_failure(): void {
        $this->assertFalse($this->validate(["gas", null]));
        $this->assertFalse($this->validate(["gas", ""]));
        $this->assertFalse($this->validate(["gas", "aosdlasd"]));
        $this->assertFalse($this->validate(["gas", 1234]));
    }

    public function test_electricity_valid_data_success(): void {
        $this->assertTrue($this->validate(["electricity", $this->options["electricity"][0]]));
    }

    public function test_electricity_invalid_data_failure(): void {
        $this->assertFalse($this->validate(["electricity", null]));
        $this->assertFalse($this->validate(["electricity", ""]));
        $this->assertFalse($this->validate(["electricity", "aosdlasd"]));
        $this->assertFalse($this->validate(["electricity", 1234]));
    }

    public function test_sewer_valid_data_success(): void {
        $this->assertTrue($this->validate(["sewer", $this->options["sewer"][0]]));
    }

    public function test_sewer_invalid_data_failure(): void {
        $this->assertFalse($this->validate(["sewer", null]));
        $this->assertFalse($this->validate(["sewer", ""]));
        $this->assertFalse($this->validate(["sewer", "aosdlasd"]));
        $this->assertFalse($this->validate(["sewer", 1234]));
    }

    public function test_area_valid_data_success(): void {
        $this->assertTrue($this->validate(["area", 1]));
        $this->assertTrue($this->validate(["area", 100]));
        $this->assertTrue($this->validate(["area", 10000]));
    }

    public function test_area_invalid_data_failure(): void {
        $this->assertFalse($this->validateField("area", null));
        $this->assertFalse($this->validateField("area", ""));
        $this->assertFalse($this->validateField("area", "aosdlasd"));
        $this->assertFalse($this->validateField("area", 0));
        $this->assertFalse($this->validateField("area", -1));
        $this->assertFalse($this->validateField("area", 10001));
        $this->assertFalse($this->validate(["area", null]));
        $this->assertFalse($this->validate(["area", ""]));
        $this->assertFalse($this->validate(["area", "aosdlasd"]));
        $this->assertFalse($this->validate(["area", 0]));
        $this->assertFalse($this->validate(["area", -1]));
        $this->assertFalse($this->validate(["area", 10001]));
    }
}
