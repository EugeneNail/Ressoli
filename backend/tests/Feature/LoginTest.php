<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class LoginTest extends TestCase {

    use RefreshDatabase;

    private string $route = "/api/login";

    private array $valid = [
        "email" => "john.doe@gmail.com",
        "password" => "StrongPassword123"
    ];

    private function createUser() {
        $data = [
            "name" => "John",
            "lastName" => "Doe",
            "email" => "john.doe@gmail.com",
            "password" => "StrongPassword123",
            "password_confirmation" => "StrongPassword123"
        ];

        $this->postJson("/api/signup", $data);
    }

    public function test_attempt_success_200(): void {
        $this->createUser();
        $response = $this->postJson($this->route, $this->valid);
        $response->assertStatus(200);
    }

    public function test_attempt_failed_password_401(): void {
        $this->createUser();
        $data = $this->valid;
        $data["password"] = "AnotherStrongPassword123";
        $response = $this->postJson($this->route, $data);
        $response->assertStatus(401)->assertJsonValidationErrors(["email", "password"]);
    }

    public function test_attempt_failed_email_401(): void {
        $this->createUser();
        $data = $this->valid;
        $data["email"] = "anthony@list.com";
        $response = $this->postJson($this->route, $data);
        $response->assertStatus(401)->assertJsonValidationErrors(["email", "password"]);
    }

    public function test_email_missing_422(): void {
        $data = $this->valid;
        unset($data["email"]);
        $response = $this->postJson($this->route, $data);
        $response->assertUnprocessable()
            ->assertJsonValidationErrors("email");
    }

    public function test_email_invalid_string_422(): void {
        $data = $this->valid;
        $data["email"] = "123";
        $response = $this->postJson($this->route, $data);
        $response->assertUnprocessable()
            ->assertJsonValidationErrors("email");
    }

    public function test_email_invalid_regex_422(): void {
        $data = $this->valid;
        $data["email"] = "joe.doe.gmail.com";
        $response = $this->postJson($this->route, $data);
        $response->assertUnprocessable()
            ->assertJsonValidationErrors("email");
    }

    public function test_password_missing_422(): void {
        $data = $this->valid;
        unset($data["password"]);
        $response = $this->postJson($this->route, $data);
        $response->assertUnprocessable()
            ->assertJsonValidationErrors("password");
    }

    public function test_password_invalid_min_422(): void {
        $data = $this->valid;
        $data["password"] = "Sp1";
        $data["password_confirmation"] = "Sp1";
        $response = $this->postJson($this->route, $data);
        $response->assertUnprocessable()
            ->assertJsonValidationErrors("password");
    }

    public function test_password_invalid_mixed_case_upper_422(): void {
        $data = $this->valid;
        $data["password"] = "STRONGPASSWORD123";
        $data["password_confirmation"] = "STRONGPASSWORD123";
        $response = $this->postJson($this->route, $data);
        $response->assertUnprocessable()
            ->assertJsonValidationErrors("password");
    }

    public function test_password_invalid_mixed_case_lower_422(): void {
        $data = $this->valid;
        $data["password"] = "strongpassword123";
        $data["password_confirmation"] = "strongpassword123";
        $response = $this->postJson($this->route, $data);
        $response->assertUnprocessable()
            ->assertJsonValidationErrors("password");
    }

    public function test_password_invalid_numbers_422(): void {
        $data = $this->valid;
        $data["password"] = "StrongPassword";
        $data["password_confirmation"] = "StrongPassword";
        $response = $this->postJson($this->route, $data);
        $response->assertUnprocessable()
            ->assertJsonValidationErrors("password");
    }

    public function test_password_invalid_letters_422(): void {
        $data = $this->valid;
        $data["password"] = "123";
        $data["password_confirmation"] = "123";
        $response = $this->postJson($this->route, $data);
        $response->assertUnprocessable()
            ->assertJsonValidationErrors("password");
    }

    public function test_password_invalid_string_422(): void {
        $data = $this->valid;
        $data["password"] = 123;
        $data["password_confirmation"] = 123;
        $response = $this->postJson($this->route, $data);
        $response->assertUnprocessable()
            ->assertJsonValidationErrors("password");
    }
}
