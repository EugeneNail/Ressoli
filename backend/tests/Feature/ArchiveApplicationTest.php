<?php

namespace Tests\Feature;

use App\Models\Application;
use Database\Seeders\StaticDataSeeder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ArchiveApplicationTest extends AuthorizedTestCase {

    private Model $application;

    public function setUp(): void {
        parent::setUp();
        $this->seed(StaticDataSeeder::class);
        $this->route = "/api/applications/1/archive";
        $this->application = Application::factory()->withHouse()->active()->create();
    }

    public function test_activate_invalid_id_404(): void {
        $response = $this->patchJson("/api/applications/999/archive");

        $response->assertStatus(404);
        $this->assertDatabaseCount(Application::class, 1);
        $this->assertDatabaseHas(Application::class, ["id" => 1, "is_active" => true]);
    }

    public function test_activate_success_204(): void {
        $response = $this->patchJson($this->route);

        $response->assertStatus(204);
        $this->assertDatabaseCount(Application::class, 1);
        $this->assertDatabaseHas(Application::class, ["id" => $this->application->id, "is_active" => false]);
        $this->assertNull(json_decode($response->getContent()));
    }
}
