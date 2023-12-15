<?php

namespace Tests\Unit;

use App\Http\Requests\StoreUserRequest;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Validator;
use PHPUnit\Framework\TestCase;

class StoreUserValidationTest extends RequestValidationTest {

    use RefreshDatabase;

    public function setUp(): void {
        parent::setUp();
        $this->rules = (new StoreUserRequest())->rules();
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

    public function test_email_valid_data_success(): void {
        $this->assertTrue($this->validateField("email", "john.doe@gmail.com"));
        $this->assertTrue($this->validateField("email", "peterwalls@list106.eu"));
    }

    public function test_email_invalid_data_failure(): void {
        $this->assertFalse($this->validateField("email", null));
        $this->assertFalse($this->validateField("email", ""));
        $this->assertFalse($this->validateField("email", "123"));
        $this->assertFalse($this->validateField("email", "joe.doe.gmail.com"));
    }

    public function test_password_valid_data_success(): void {
        $this->assertTrue($this->validateField("password", "StrongPassword123"));
        $this->assertTrue($this->validateField("password", "MegaGurrenBurrenPassword999999"));
    }

    public function test_password_invalid_data_failure(): void {
        $this->assertFalse($this->validateField("password", null));
        $this->assertFalse($this->validateField("password", ""));
        $this->assertFalse($this->validateField("password", "Sp1"));
        $this->assertFalse($this->validateField("password", "STRONGPASSWORD123"));
        $this->assertFalse($this->validateField("password", "strongpassword123"));
        $this->assertFalse($this->validateField("password", "StrongPassword"));
        $this->assertFalse($this->validateField("password", "123456789"));
        $this->assertFalse($this->validateField("password",  123456789));
    }

    public function test_password_confirmation_valid_data_success(): void {
        $isMatching = Validator::make(
            [
                "password" => "StrongPassword123",
                "password_confirmation" => "StrongPassword123"
            ],
            [
                "password" => $this->rules["password"],
                "password_confirmation" => $this->rules["password_confirmation"]
            ]
        )->passes();
        $this->assertTrue($isMatching);
    }

    public function test_password_confirmation_invalid_data_failure(): void {
        $isMatching = Validator::make(
            [
                "password" => "StrongPassword123",
                "password_confirmation" => "StringPassword123"
            ],
            [
                "password" => $this->rules["password"],
                "password_confirmation" => $this->rules["password_confirmation"]
            ]
        )->passes();
        $this->assertFalse($isMatching);
    }
}
