<?php

namespace Tests\Feature;

use App\Models\Client;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class StoreClientFeatureTest extends AuthorizedTestCase {

    use RefreshDatabase;

    protected function setUp(): void {
        parent::setUp();
        $this->route = "/api/clients";
        $this->data = Client::factory()->test()->make()->toArray();
    }

    public function test_valid_data_201(): void {
        $response = $this->postJson($this->route, $this->data);

        $response->assertStatus(201);
        $this->assertDatabaseHas(Client::class, $this->data);
    }

    public function test_with_existing_number_different_names_409(): void {
        $this->postJson($this->route, $this->data);
        $this->data["name"] = "Jonathan";
        $this->data["last_name"] = "Donutson";
        $response = $this->postJson($this->route, $this->data);

        $response->assertStatus(409);
    }

    public function test_client_with_existing_number_same_names_data_200(): void {
        $this->postJson($this->route, $this->data);
        $response = $this->postJson($this->route, $this->data);

        $response->assertStatus(200);
        $this->assertDatabaseHas(Client::class, $this->data);
        $this->assertDatabaseCount(Client::class, 1);
    }

    public function test_wrong_http_method_405(): void {
        $response = $this->putJson($this->route, $this->data);

        $response->assertStatus(405);
    }
}
