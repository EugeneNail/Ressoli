<?php

namespace Tests\Feature;

use App\Models\User;
use Database\Seeders\TestUserSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class LogoutTest extends TestCase {

    use RefreshDatabase;

    private string $route = "/api/logout";

    private string $token = '1|3t0ix4PEXkDOgssDYkqZDo9i7ynEhcxgWI159aBHc3e24611';

    public function test_valid_header_200() {
        $this->seed(TestUserSeeder::class);
        $response = $this->withHeader("Authorization", "Bearer " . $this->token)
            ->postJson($this->route);

        $response->assertStatus(204);
    }

    public function test_no_header_401() {
        $this->seed(TestUserSeeder::class);
        $response = $this->postJson($this->route);

        $response->assertStatus(401);
    }

    public function test_empty_header_401() {
        $this->seed(TestUserSeeder::class);
        $response = $this->withHeader("Authorization", "")
            ->postJson($this->route);

        $response->assertStatus(401);
    }

    public function test_no_bearer_401() {
        $this->seed(TestUserSeeder::class);
        $response = $this->withHeader("Authorization", $this->token)
            ->postJson($this->route);

        $response->assertStatus(401);
    }

    public function test_no_token_401() {
        $this->seed(TestUserSeeder::class);
        $response = $this->withHeader("Authorization", "Bearer ")
            ->postJson($this->route);

        $response->assertStatus(401);
    }
}
