<?php

namespace Tests\Unit;

use App\Http\Requests\StoreUserRequest;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Validator;
use PHPUnit\Framework\TestCase;

class StoreUserValidationTest extends ValidationTestCase {

    use RefreshDatabase;

    public function setUp(): void {
        parent::setUp();
        $this->rules = (new StoreUserRequest())->rules();
    }

    public function test_name_valid_data_success(): void {
        $this->assertTrue($this->validate(["name", "John"]));
        $this->assertTrue($this->validate(["name", "Anthony"]));
        $this->assertTrue($this->validate(["name", "Barbara"]));
    }

    public function test_name_invalid_data_failure(): void {
        $this->assertFalse($this->validate(["name", null]));
        $this->assertFalse($this->validate(["name", ""]));
        $this->assertFalse($this->validate(["name", 123]));
        $this->assertFalse($this->validate(["name", "a"]));
        $this->assertFalse($this->validate(["name", "abcd-abcd-abcd-abcd-abcd-abcd"]));
        $this->assertFalse($this->validate(["name", "John-"]));
    }

    public function test_last_name_valid_data_success(): void {
        $this->assertTrue($this->validate(["last_name", "Walls"]));
        $this->assertTrue($this->validate(["last_name", "Bridges"]));
        $this->assertTrue($this->validate(["last_name", "McMillend"]));
    }

    public function test_last_name_invalid_data_failure(): void {
        $this->assertFalse($this->validate(["last_name", null]));
        $this->assertFalse($this->validate(["last_name", ""]));
        $this->assertFalse($this->validate(["last_name", 123]));
        $this->assertFalse($this->validate(["last_name", "a"]));
        $this->assertFalse($this->validate(["last_name", "abcd-abcd-abcd-abcd-abcd-abcd"]));
        $this->assertFalse($this->validate(["last_name", "Doe-"]));
    }

    public function test_email_valid_data_success(): void {
        $this->assertTrue($this->validate(["email", "john.doe@gmail.com"]));
        $this->assertTrue($this->validate(["email", "peterwalls@list106.eu"]));
    }

    public function test_email_invalid_data_failure(): void {
        $this->assertFalse($this->validate(["email", null]));
        $this->assertFalse($this->validate(["email", ""]));
        $this->assertFalse($this->validate(["email", "123"]));
        $this->assertFalse($this->validate(["email", "joe.doe.gmail.com"]));
    }

    public function test_password_valid_data_success(): void {
        $this->assertTrue($this->validate(["password", "StrongPassword123"]));
        $this->assertTrue($this->validate(["password", "MegaGurrenBurrenPassword999999"]));
    }

    public function test_password_invalid_data_failure(): void {
        $this->assertFalse($this->validate(["password", null]));
        $this->assertFalse($this->validate(["password", ""]));
        $this->assertFalse($this->validate(["password", "Sp1"]));
        $this->assertFalse($this->validate(["password", "STRONGPASSWORD123"]));
        $this->assertFalse($this->validate(["password", "strongpassword123"]));
        $this->assertFalse($this->validate(["password", "StrongPassword"]));
        $this->assertFalse($this->validate(["password", "123456789"]));
        $this->assertFalse($this->validate(["password", 123456789]));
    }

    public function test_password_confirmation_valid_data_success(): void {
        $this->assertTrue($this->validate(
            ["password", "StrongPassword123"],
            ["password_confirmation", "StrongPassword123"]
        ));
    }

    public function test_password_confirmation_invalid_data_failure(): void {
        $this->assertFalse($this->validate(
            ["password", "StrongPassword123"],
            ["password_confirmation", "StringPassword123"]
        ));
    }
}
