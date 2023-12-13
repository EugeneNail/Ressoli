<?php

namespace Tests\Feature;

use App\Models\User;
use Database\Seeders\StaticDataSeeder;
use Database\Seeders\TestUserSeeder;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AuthorizedTestCase extends TestCase {

    use RefreshDatabase;

    protected function setUp(): void {
        parent::setUp();
        $this->actingAs(User::factory()->test()->create());
    }
}
