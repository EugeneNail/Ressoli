<?php

namespace Tests\Feature;

use App\Models\User;
use Database\Seeders\TestUserSeeder;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AuthorizedTestCase extends TestCase {

    use RefreshDatabase;

    protected string $route;

    protected array $data;

    protected function setUp(): void {
        parent::setUp();
        $this->seed(TestUserSeeder::class);
        $this->actingAs(User::first());
    }
}
