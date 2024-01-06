<?php

namespace Tests\Unit;

use App\Http\Requests\LoginRequest;
use Illuminate\Support\Facades\Validator;
use PHPUnit\Framework\TestCase;

class LoginValidationTest extends ValidationTestCase {

    public function setUp(): void {
        parent::setUp();
        $this->setRules(LoginRequest::class);
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
}
