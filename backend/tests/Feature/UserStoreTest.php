<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class UserStoreTest extends TestCase {

    use RefreshDatabase;

    private array $valid = [
        "name" => "John",
        "lastName" => "Doe",
        "email" => "joh.doe@gmail.com",
        "password" => "StrongPassword123",
        "password_confirmation" => "StrongPassword123"
    ];

    public function test_valid_data_201(): void {
        $response = $this->postJson('/api/signup', $this->valid);
        $response->assertCreated()
            ->assertJsonStructure(["token"]);
        $this->assertDatabaseHas(User::class, [
            "name" => $this->valid["name"],
            "lastName" => $this->valid["lastName"],
            "email" => $this->valid["email"],
        ]);
    }

    public function test_name_missing_422(): void {
        $data = $this->valid;
        unset($data["name"]);
        $response = $this->postJson("/api/signup", $data);
        $response->assertUnprocessable()
            ->assertJsonValidationErrors("name");
    }

    public function test_name_invalid_alpha_422(): void {
        $data = $this->valid;
        $data["name"] = "123";
        $response = $this->postJson("/api/signup", $data);
        $response->assertUnprocessable()
            ->assertJsonValidationErrors("name");
    }

    public function test_name_invalid_string_422(): void {
        $data = $this->valid;
        $data["name"] = 123;
        $response = $this->postJson("/api/signup", $data);
        $response->assertUnprocessable()
            ->assertJsonValidationErrors("name");
    }

    public function test_lastname_missing_422(): void {
        $data = $this->valid;
        unset($data["lastName"]);
        $response = $this->postJson("/api/signup", $data);
        $response->assertUnprocessable()
            ->assertJsonValidationErrors("lastName");
    }

    public function test_lastname_invalid_alpha_422(): void {
        $data = $this->valid;
        $data["lastName"] = "123";
        $response = $this->postJson("/api/signup", $data);
        $response->assertUnprocessable()
            ->assertJsonValidationErrors("lastName");
    }

    public function test_lastname_invalid_string_422(): void {
        $data = $this->valid;
        $data["lastName"] = 123;
        $response = $this->postJson("/api/signup", $data);
        $response->assertUnprocessable()
            ->assertJsonValidationErrors("lastName");
    }

    public function test_email_missing_422(): void {
        $data = $this->valid;
        unset($data["email"]);
        $response = $this->postJson("/api/signup", $data);
        $response->assertUnprocessable()
            ->assertJsonValidationErrors("email");
    }

    public function test_email_invalid_string_422(): void {
        $data = $this->valid;
        $data["email"] = "123";
        $response = $this->postJson("/api/signup", $data);
        $response->assertUnprocessable()
            ->assertJsonValidationErrors("email");
    }

    public function test_email_invalid_regex_422(): void {
        $data = $this->valid;
        $data["email"] = "joe.doe.gmail.com";
        $response = $this->postJson("/api/signup", $data);
        $response->assertUnprocessable()
            ->assertJsonValidationErrors("email");
    }

    public function test_email_invalid_unique_422(): void {
        $response = $this->postJson("/api/signup", $this->valid);
        $response = $this->postJson("/api/signup", $this->valid);
        $response->assertUnprocessable()
            ->assertJsonValidationErrors("email");
    }

    public function test_password_missing_422(): void {
        $data = $this->valid;
        unset($data["password"]);
        $response = $this->postJson("/api/signup", $data);
        $response->assertUnprocessable()
            ->assertJsonValidationErrors("password");
    }

    public function test_password_invalid_min_422(): void {
        $data = $this->valid;
        $data["password"] = "Sp1";
        $data["password_confirmation"] = "Sp1";
        $response = $this->postJson("/api/signup", $data);
        $response->assertUnprocessable()
            ->assertJsonValidationErrors("password");
    }

    public function test_password_invalid_mixed_case_upper_422(): void {
        $data = $this->valid;
        $data["password"] = "STRONGPASSWORD123";
        $data["password_confirmation"] = "STRONGPASSWORD123";
        $response = $this->postJson("/api/signup", $data);
        $response->assertUnprocessable()
            ->assertJsonValidationErrors("password");
    }

    public function test_password_invalid_mixed_case_lower_422(): void {
        $data = $this->valid;
        $data["password"] = "strongpassword123";
        $data["password_confirmation"] = "strongpassword123";
        $response = $this->postJson("/api/signup", $data);
        $response->assertUnprocessable()
            ->assertJsonValidationErrors("password");
    }

    public function test_password_invalid_numbers_422(): void {
        $data = $this->valid;
        $data["password"] = "StrongPassword";
        $data["password_confirmation"] = "StrongPassword";
        $response = $this->postJson("/api/signup", $data);
        $response->assertUnprocessable()
            ->assertJsonValidationErrors("password");
    }

    public function test_password_invalid_letters_422(): void {
        $data = $this->valid;
        $data["password"] = "123";
        $data["password_confirmation"] = "123";
        $response = $this->postJson("/api/signup", $data);
        $response->assertUnprocessable()
            ->assertJsonValidationErrors("password");
    }

    public function test_password_invalid_string_422(): void {
        $data = $this->valid;
        $data["password"] = 123;
        $data["password_confirmation"] = 123;
        $response = $this->postJson("/api/signup", $data);
        $response->assertUnprocessable()
            ->assertJsonValidationErrors("password");
    }

    public function test_password_confirmation_missing_422(): void {
        $data = $this->valid;
        unset($data["password_confirmation"]);
        $response = $this->postJson("/api/signup", $data);
        $response->assertUnprocessable()
            ->assertJsonValidationErrors("password_confirmation");
    }

    public function test_password_confirmation_invalid_string_422(): void {
        $data = $this->valid;
        $data["password_confirmation"] = 123;
        $response = $this->postJson("/api/signup", $data);
        $response->assertUnprocessable()
            ->assertJsonValidationErrors("password_confirmation");
    }

    public function test_password_confirmation_invalid_same_422(): void {
        $data = $this->valid;
        $data["password_confirmation"] = "StrongPassword124";
        $response = $this->postJson("/api/signup", $data);
        $response->assertUnprocessable()
            ->assertJsonValidationErrors("password_confirmation");
    }
}
