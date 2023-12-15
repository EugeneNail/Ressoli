<?php

namespace Tests\Unit;

use App\Http\Requests\LoginRequest;
use Illuminate\Support\Facades\Validator;
use PHPUnit\Framework\TestCase;

class LoginValidationTest extends RequestValidationTest {

    public function setUp(): void {
        parent::setUp();
        $this->rules = (new LoginRequest())->rules();
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
}
