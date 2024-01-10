<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class StoreUserFeatureTest extends TestCase {

    use RefreshDatabase;

    private string $route = "/api/signup";

    private array $data;

    public function setUp(): void {
        parent::setUp();
        $this->data = [
            "name" => "John",
            "last_name" => "Doe",
            "email" => "john.doe@gmail.com",
            "password" => "StrongPassword123",
            "password_confirmation" => "StrongPassword123",
        ];
    }

    public function test_valid_data_201(): void {
        $response = $this->postJson($this->route, $this->data);
        $response->assertStatus(204);

        $this->assertDatabaseHas(User::class, [
            "name" => "John",
            "last_name" => "Doe",
            "email" => "john.doe@gmail.com",
        ]);

        $response->assertCookie("access_token");
    }

    public function test_invalid_data_422(): void {
        $response = $this->postJson($this->route, []);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(["name", "lastName", "email", "password", "passwordConfirmation"]);
        $this->assertDatabaseCount(User::class, 0);
        $response->assertCookieMissing("access_token");
    }

    public function test_duplicate_email_409(): void {
        $this->postJson($this->route, $this->data);
        $response = $this->postJson($this->route, $this->data);

        $response->assertStatus(409);
        $this->assertDatabaseCount(User::class, 1);
        $response->assertJsonValidationErrors("email");
        $response->assertCookieMissing("access_token");
    }
}
