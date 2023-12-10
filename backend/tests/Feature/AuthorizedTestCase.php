<?php

namespace Tests\Feature;

use App\Models\User;
use Database\Seeders\TestUserSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AuthorizedTestCase extends TestCase {

    protected $seed = true;

    protected $seeder = TestUserSeeder::class;

    protected function setUp(): void {
        parent::setUp();
        $this->actingAs(User::first());
    }
}
