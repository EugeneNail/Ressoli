<?php

namespace Tests\Unit;

use App\Http\Requests\UpdateLandParcelRequest;
use Database\Seeders\LandParcelOptionsSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UpdateLandParcelValidationTest extends RequestValidationTest {

    use RefreshDatabase;

    public function setUp(): void {
        parent::setUp();
        $this->seed(LandParcelOptionsSeeder::class);
        $this->rules = (new UpdateLandParcelRequest())->rules();
    }

    public function test_water_valid_data_success(): void {
        $this->assertTrue($this->validateField("water", "None"));
        $this->assertTrue($this->validateField("water", "On the boundary"));
        $this->assertTrue($this->validateField("water", "Well"));
    }

    public function test_water_invalid_data_failure(): void {
        $this->assertFalse($this->validateField("water", null));
        $this->assertFalse($this->validateField("water", ""));
        $this->assertFalse($this->validateField("water", "aosdlasd"));
        $this->assertFalse($this->validateField("water", 1234));
    }

    public function test_gas_valid_data_success(): void {
        $this->assertTrue($this->validateField("gas", "None"));
        $this->assertTrue($this->validateField("gas", "On the boundary"));
        $this->assertTrue($this->validateField("gas", "Gas holder"));
    }

    public function test_gas_invalid_data_failure(): void {
        $this->assertFalse($this->validateField("gas", null));
        $this->assertFalse($this->validateField("gas", ""));
        $this->assertFalse($this->validateField("gas", "aosdlasd"));
        $this->assertFalse($this->validateField("gas", 1234));
    }

    public function test_electricity_valid_data_success(): void {
        $this->assertTrue($this->validateField("electricity", "None"));
        $this->assertTrue($this->validateField("electricity", "On the boundary"));
        $this->assertTrue($this->validateField("electricity", "Overhead line"));
    }

    public function test_electricity_invalid_data_failure(): void {
        $this->assertFalse($this->validateField("electricity", null));
        $this->assertFalse($this->validateField("electricity", ""));
        $this->assertFalse($this->validateField("electricity", "aosdlasd"));
        $this->assertFalse($this->validateField("electricity", 1234));
    }

    public function test_sewer_valid_data_success(): void {
        $this->assertTrue($this->validateField("sewer", "None"));
        $this->assertTrue($this->validateField("sewer", "On the boundary"));
        $this->assertTrue($this->validateField("sewer", "Cesspool"));
        $this->assertTrue($this->validateField("sewer", "None"));
    }

    public function test_sewer_invalid_data_failure(): void {
        $this->assertFalse($this->validateField("sewer", null));
        $this->assertFalse($this->validateField("sewer", ""));
        $this->assertFalse($this->validateField("sewer", "aosdlasd"));
        $this->assertFalse($this->validateField("sewer", 1234));
    }

    public function test_area_valid_data_success(): void {
        $this->assertTrue($this->validateField("area", 1));
        $this->assertTrue($this->validateField("area", 100));
        $this->assertTrue($this->validateField("area", 100.123123));
        $this->assertTrue($this->validateField("area", 9999.999));
        $this->assertTrue($this->validateField("area", 10000));
    }

    public function test_area_invalid_data_failure(): void {
        $this->assertFalse($this->validateField("area", null));
        $this->assertFalse($this->validateField("area", ""));
        $this->assertFalse($this->validateField("area", "aosdlasd"));
        $this->assertFalse($this->validateField("area", 0));
        $this->assertFalse($this->validateField("area", -1));
        $this->assertFalse($this->validateField("area", 10001));
    }
}
