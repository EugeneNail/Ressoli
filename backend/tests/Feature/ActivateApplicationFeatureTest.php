<?php

namespace Tests\Feature;

use App\Models\Application;
use App\Models\User;
use Database\Seeders\GlobalOptionsSeeder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ActivateApplicationFeatureTest extends AuthorizedTestCase {

    private Model $application;

    public function setUp(): void {
        parent::setUp();
        $this->seed(GlobalOptionsSeeder::class);
        $this->route = "/api/applications/1/activate";
        $this->application = Application::factory()
            ->withHouse()
            ->inactive()
            ->withUser(User::first())
            ->create();
    }

    public function test_activate_invalid_id_404(): void {
        $response = $this->patchJson("/api/applications/999/activate");

        $response->assertStatus(404);
        $this->assertDatabaseCount(Application::class, 1);
        $this->assertDatabaseHas(Application::class, ["id" => 1, "is_active" => false]);
    }

    public function test_activate_success_204(): void {
        $response = $this->patchJson($this->route);

        $response->assertStatus(204);
        $this->assertDatabaseCount(Application::class, 1);
        $this->assertDatabaseHas(Application::class, ["id" => $this->application->id, "is_active" => true]);
        $this->assertNull(json_decode($response->getContent()));
    }

    public function test_activate_others_user_application_403(): void {
        $response = $this->actingAs(User::factory()->create())->patchJson($this->route);

        $response->assertStatus(403);
        $this->assertDatabaseMissing(Application::class, ["id" => 1, "is_active" => true]);
        $this->assertDatabaseCount(Application::class, 1);
    }
}
