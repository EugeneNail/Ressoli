<?php

namespace Tests\Unit;

use App\Http\Requests\StoreClientRequest;
use PHPUnit\Framework\TestCase;

class StoreClientValidationTest extends RequestValidationTest {

    public function setUp(): void {
        parent::setUp();
        $this->rules = (new StoreClientRequest())->rules();
    }

    public function test_name_valid_data_success(): void {
        $this->assertTrue($this->validateField("name", "John"));
        $this->assertTrue($this->validateField("name", "Anthony"));
        $this->assertTrue($this->validateField("name", "Barbara"));
    }

    public function test_name_invalid_data_failure(): void {
        $this->assertFalse($this->validateField("name", null));
        $this->assertFalse($this->validateField("name", ""));
        $this->assertFalse($this->validateField("name", 123));
        $this->assertFalse($this->validateField("name", "a"));
        $this->assertFalse($this->validateField("name", "abcd-abcd-abcd-abcd-abcd-abcd"));
        $this->assertFalse($this->validateField("name", "John-"));
    }

    public function test_last_name_valid_data_success(): void {
        $this->assertTrue($this->validateField("last_name", "Walls"));
        $this->assertTrue($this->validateField("last_name", "Bridges"));
        $this->assertTrue($this->validateField("last_name", "McMillend"));
    }

    public function test_last_name_invalid_data_failure(): void {
        $this->assertFalse($this->validateField("last_name", null));
        $this->assertFalse($this->validateField("last_name", ""));
        $this->assertFalse($this->validateField("last_name", 123));
        $this->assertFalse($this->validateField("last_name", "a"));
        $this->assertFalse($this->validateField("last_name", "abcd-abcd-abcd-abcd-abcd-abcd"));
        $this->assertFalse($this->validateField("last_name", "Doe-"));
    }

    public function test_phone_number_valid_data_success(): void {
        $this->assertTrue($this->validateField("phone_number", "1-234-567-8900"));
        $this->assertTrue($this->validateField("phone_number", "8-800-555-3535"));
        $this->assertTrue($this->validateField("phone_number", "4-429-356-1256"));
    }

    public function test_phone_number_invalid_data_failure(): void {
        $this->assertFalse($this->validateField("phone_number", null));
        $this->assertFalse($this->validateField("phone_number", ""));
        $this->assertFalse($this->validateField("phone_number", 12345678900));
        $this->assertFalse($this->validateField("phone_number", "12345678900"));
        $this->assertFalse($this->validateField("phone_number", "1-234-567-890c"));
        $this->assertFalse($this->validateField("phone_number", "1-234-567-89000"));
        $this->assertFalse($this->validateField("phone_number", "1-2344-567-800"));
        $this->assertFalse($this->validateField("phone_number", "a-bcd-efg-hijk"));
    }
}
