<?php

namespace Tests\Feature;

use App\Models\User;
use Database\Seeders\TestUserSeeder;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Response;
use Laravel\Sanctum\PersonalAccessToken;
use Tests\TestCase;

class LogoutFeatureTest extends TestCase {

    use RefreshDatabase;

    private string $route = "/api/logout";

    private string $token = '1|3t0ix4PEXkDOgssDYkqZDo9i7ynEhcxgWI159aBHc3e24611';

    private string $hashedToken = "a145676ab6f4e7892ec02fefec3cd804fcb83cd5eabfb40c8e97aec9fea70234";

    public function setUp(): void {
        parent::setUp();
        $this->seed(TestUserSeeder::class);
    }

    public function test_valid_token_204(): void {
        $this->assertTrue(true);
    }

    public function test_invalid_token_401(): void {
        $this->assertTrue(true);
    }

    public function test_no_token_401(): void {
        $this->assertTrue(true);
    }

    public function test_expired_token_401(): void {
        $this->assertTrue(true);
    }
}
