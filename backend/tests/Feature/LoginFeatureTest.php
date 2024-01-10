<?php

namespace Tests\Feature;

use App\Models\User;
use Database\Seeders\TestUserSeeder;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class LoginFeatureTest extends TestCase {

    use RefreshDatabase;

    private string $route = "/api/login";

    private array $data = [
        "email" => "john.doe@gmail.com",
        "password" => "StrongPassword123"
    ];

    public function setUp(): void {
        parent::setUp();
        User::factory()->test()->create();
    }


    public function test_success_204(): void {
        $response = $this->postJson($this->route, $this->data);
        $response->assertStatus(204);
        $response->assertCookie("access_token");
    }

    public function test_invalid_password_401(): void {
        $this->data["password"] = "AnotherStrongPassword123";
        $response = $this->postJson($this->route, $this->data);

        $response->assertStatus(401)->assertJsonValidationErrors(["email", "password"]);
        $response->assertCookieMissing("access_token");
    }

    public function test_invalid_email_401(): void {
        $this->data["email"] = "anthony@list.com";
        $response = $this->postJson($this->route, $this->data);

        $response->assertStatus(401)->assertJsonValidationErrors(["email", "password"]);
        $response->assertCookieMissing("access_token");
    }
}
