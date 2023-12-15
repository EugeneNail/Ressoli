<?php

namespace Tests\Unit;

use App\Actions\GetOptions;
use App\Http\Requests\StoreAddressRequest;
use Database\Seeders\AddressOptionsSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\TestCase;

class StoreAddressValidationTest extends RequestValidationTest {

    use RefreshDatabase;

    public function setUp(): void {
        parent::setUp();
        $this->seed(AddressOptionsSeeder::class);
        $this->rules = (new StoreAddressRequest())->rules($this->app->make(GetOptions::class));
    }

    public function test_number_valid_data_success(): void {
        $this->assertTrue($this->validateField("number", "22a"));
        $this->assertTrue($this->validateField("number", "1/150"));
        $this->assertTrue($this->validateField("number", "56 b"));
        $this->assertTrue($this->validateField("number", "99b / 44"));
    }

    public function test_number_invalid_data_failure(): void {
        $this->assertFalse($this->validateField("number", null));
        $this->assertFalse($this->validateField("number", ""));
        $this->assertFalse($this->validateField("number", "?"));
        $this->assertFalse($this->validateField("number", "*"));
        $this->assertFalse($this->validateField("number", "abcd-abcd-abcd"));
    }

    public function test_unit_valid_data_success(): void {
        $this->assertTrue($this->validateField("unit", null));
        $this->assertTrue($this->validateField("unit", ""));
        $this->assertTrue($this->validateField("unit", "22a"));
        $this->assertTrue($this->validateField("unit", "1/150"));
        $this->assertTrue($this->validateField("unit", "56 b"));
        $this->assertTrue($this->validateField("unit", "99b / 44"));
    }

    public function test_unit_invalid_data_failure(): void {
        $this->assertFalse($this->validateField("unit", "?"));
        $this->assertFalse($this->validateField("unit", "*"));
        $this->assertFalse($this->validateField("unit", "abcd-abcd-abcd"));
    }

    public function test_type_of_street_valid_data_success(): void {
        $this->assertTrue($this->validateField("type_of_street", "St"));
        $this->assertTrue($this->validateField("type_of_street", "Ave"));
        $this->assertTrue($this->validateField("type_of_street", "Blvd"));
    }

    public function test_type_of_street_invalid_data_failure(): void {
        $this->assertFalse($this->validateField("type_of_street", ""));
        $this->assertFalse($this->validateField("type_of_street", 123));
        $this->assertFalse($this->validateField("type_of_street", "None"));
        $this->assertFalse($this->validateField("type_of_street", "You're breathtaking"));
    }

    public function test_street_valid_data_success(): void {
        $this->assertTrue($this->validateField("street", "Pennsylvania"));
        $this->assertTrue($this->validateField("street", "Born-Tauned"));
        $this->assertTrue($this->validateField("street", "Large Hills"));
        $this->assertTrue($this->validateField("street", "Matt/Daves"));
    }

    public function test_street_invalid_data_failure(): void {
        $this->assertFalse($this->validateField("street", null));
        $this->assertFalse($this->validateField("street", ""));
        $this->assertFalse($this->validateField("street", "A"));
        $this->assertFalse($this->validateField("street", "abcd-abcd-abcd-abcd-abcd-abcd-abcd"));
        $this->assertFalse($this->validateField("street", "?"));
        $this->assertFalse($this->validateField("street", "*"));
    }

    public function test_city_valid_data_success(): void {
        $this->assertTrue($this->validateField("city", "Washington"));
        $this->assertTrue($this->validateField("city", "Berlin"));
        $this->assertTrue($this->validateField("city", "Yoshkar-Ola"));
        $this->assertTrue($this->validateField("city", "Tokyo"));
    }

    public function test_city_invalid_data_failure(): void {
        $this->assertFalse($this->validateField("city", null));
        $this->assertFalse($this->validateField("city", ""));
        $this->assertFalse($this->validateField("city", "A"));
        $this->assertFalse($this->validateField("city", "abcd-abcd-abcd-abcd-abcd-abcd-abcd"));
        $this->assertFalse($this->validateField("city", "?"));
        $this->assertFalse($this->validateField("city", "*"));
    }

    public function test_postal_code_valid_data_success(): void {
        $this->assertTrue($this->validateField("postal_code", null));
        $this->assertTrue($this->validateField("postal_code", ""));
    }

    public function test_postal_code_invalid_data_failure(): void {
        $this->assertFalse($this->validateField("postal_code", "abcd-abcd-abcd"));
        $this->assertFalse($this->validateField("postal_code", "123456789"));
        $this->assertFalse($this->validateField("postal_code", "?"));
        $this->assertFalse($this->validateField("postal_code", "*"));
    }
}
