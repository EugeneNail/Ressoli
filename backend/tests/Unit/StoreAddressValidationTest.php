<?php

namespace Tests\Unit;

use App\Actions\GetOptions;
use App\Http\Requests\StoreAddressRequest;
use Database\Seeders\AddressOptionsSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\TestCase;

class StoreAddressValidationTest extends ValidationTestCase {

    use RefreshDatabase;

    public function setUp(): void {
        parent::setUp();
        $this->seed(AddressOptionsSeeder::class);
        $this->setRules(StoreAddressRequest::class);
    }

    public function test_number_valid_data_success(): void {
        $this->assertTrue($this->validate(["number", "22a"]));
        $this->assertTrue($this->validate(["number", "1/150"]));
        $this->assertTrue($this->validate(["number", "56 b"]));
        $this->assertTrue($this->validate(["number", "99b / 44"]));
    }

    public function test_number_invalid_data_failure(): void {
        $this->assertFalse($this->validate(["number", null]));
        $this->assertFalse($this->validate(["number", ""]));
        $this->assertFalse($this->validate(["number", "?"]));
        $this->assertFalse($this->validate(["number", "*"]));
        $this->assertFalse($this->validate(["number", "abcd-abcd-abcd"]));
    }

    public function test_unit_valid_data_success(): void {
        $this->assertTrue($this->validate(["unit", null]));
        $this->assertTrue($this->validate(["unit", ""]));
        $this->assertTrue($this->validate(["unit", "22a"]));
        $this->assertTrue($this->validate(["unit", "1/150"]));
        $this->assertTrue($this->validate(["unit", "56 b"]));
        $this->assertTrue($this->validate(["unit", "99b / 44"]));
    }

    public function test_unit_invalid_data_failure(): void {
        $this->assertFalse($this->validate(["unit", "?"]));
        $this->assertFalse($this->validate(["unit", "*"]));
        $this->assertFalse($this->validate(["unit", "abcd-abcd-abcd"]));
    }

    public function test_type_of_street_valid_data_success(): void {
        $this->assertTrue($this->validate(["type_of_street", "St"]));
        $this->assertTrue($this->validate(["type_of_street", "Ave"]));
        $this->assertTrue($this->validate(["type_of_street", "Blvd"]));
    }

    public function test_type_of_street_invalid_data_failure(): void {
        $this->assertFalse($this->validate(["type_of_street", ""]));
        $this->assertFalse($this->validate(["type_of_street", 123]));
        $this->assertFalse($this->validate(["type_of_street", "None"]));
        $this->assertFalse($this->validate(["type_of_street", "You're breathtaking"]));
    }

    public function test_street_valid_data_success(): void {
        $this->assertTrue($this->validate(["street", "Pennsylvania"]));
        $this->assertTrue($this->validate(["street", "Born-Tauned"]));
        $this->assertTrue($this->validate(["street", "Large Hills"]));
        $this->assertTrue($this->validate(["street", "Matt/Daves"]));
    }

    public function test_street_invalid_data_failure(): void {
        $this->assertFalse($this->validate(["street", null]));
        $this->assertFalse($this->validate(["street", ""]));
        $this->assertFalse($this->validate(["street", "A"]));
        $this->assertFalse($this->validate(["street", "abcd-abcd-abcd-abcd-abcd-abcd-abcd"]));
        $this->assertFalse($this->validate(["street", "?"]));
        $this->assertFalse($this->validate(["street", "*"]));
    }

    public function test_city_valid_data_success(): void {
        $this->assertTrue($this->validate(["city", "Washington"]));
        $this->assertTrue($this->validate(["city", "Berlin"]));
        $this->assertTrue($this->validate(["city", "Yoshkar-Ola"]));
        $this->assertTrue($this->validate(["city", "Tokyo"]));
    }

    public function test_city_invalid_data_failure(): void {
        $this->assertFalse($this->validate(["city", null]));
        $this->assertFalse($this->validate(["city", ""]));
        $this->assertFalse($this->validate(["city", "A"]));
        $this->assertFalse($this->validate(["city", "abcd-abcd-abcd-abcd-abcd-abcd-abcd"]));
        $this->assertFalse($this->validate(["city", "?"]));
        $this->assertFalse($this->validate(["city", "*"]));
    }

    public function test_postal_code_valid_data_success(): void {
        $this->assertTrue($this->validate(["postal_code", null]));
        $this->assertTrue($this->validate(["postal_code", ""]));
    }

    public function test_postal_code_invalid_data_failure(): void {
        $this->assertFalse($this->validate(["postal_code", "abcd-abcd-abcd"]));
        $this->assertFalse($this->validate(["postal_code", "123456789"]));
        $this->assertFalse($this->validate(["postal_code", "?"]));
        $this->assertFalse($this->validate(["postal_code", "*"]));
    }
}
