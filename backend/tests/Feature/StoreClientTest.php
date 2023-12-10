<?php

namespace Tests\Feature;

use App\Models\Client;
use App\Models\User;
use Database\Seeders\TestClientSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class StoreClientTest extends AuthorizedTestCase {

    use RefreshDatabase;

    private string $route = "/api/clients";

    private array $valid = [
        "name" => "John",
        "lastName" => "Doe",
        "phoneNumber" => "1-234-567-8900"
    ];

    public function test_create_client_valid_data_201(): void {
        $response = $this->postJson($this->route, $this->valid);
        $response->assertStatus(201);
        $this->assertDatabaseHas(Client::class, [
            "id" => 1,
            "name" => $this->valid["name"],
            "last_name" => $this->valid["lastName"],
            "phone_number" => $this->valid["phoneNumber"],
        ]);
    }

    public function test_client_with_existing_number_different_names_data_409(): void {
        $this->seed(TestClientSeeder::class);
        $this->valid["name"] = "Jonathan";
        $this->valid["lastName"] = "Donutson";
        $response = $this->postJson($this->route, $this->valid);
        $response->assertStatus(409);
    }

    public function test_client_with_existing_number_same_names_data_200(): void {
        $this->seed(TestClientSeeder::class);
        $response = $this->postJson($this->route, $this->valid);
        $response->assertStatus(200);
        $this->assertDatabaseHas(Client::class, [
            "id" => 1,
            "name" => $this->valid["name"],
            "last_name" => $this->valid["lastName"],
            "phone_number" => $this->valid["phoneNumber"],
        ]);
        $this->assertEquals(1, count(Client::all()));
    }

    public function test_wrong_http_method_405(): void {
        $response = $this->putJson($this->route, $this->valid);
        $response->assertStatus(405);
    }

    public function test_name_missing_422(): void {
        unset($this->valid["name"]);
        $response = $this->postJson($this->route, $this->valid);
        $response->assertStatus(422)
            ->assertJsonValidationErrors("name");
    }

    public function test_name_invalid_alpha_422(): void {
        $this->valid["name"] = "123";
        $response = $this->postJson($this->route, $this->valid);
        $response->assertStatus(422)
            ->assertJsonValidationErrors("name");
    }

    public function test_name_invalid_string_422(): void {
        $this->valid["name"] = 123;
        $response = $this->postJson($this->route, $this->valid);
        $response->assertStatus(422)
            ->assertJsonValidationErrors("name");
    }

    public function test_last_name_missing_422(): void {
        unset($this->valid["lastName"]);
        $response = $this->postJson($this->route, $this->valid);
        $response->assertStatus(422)
            ->assertJsonValidationErrors("lastName");
    }

    public function test_last_name_invalid_alpha_422(): void {
        $this->valid["lastName"] = "123";
        $response = $this->postJson($this->route, $this->valid);
        $response->assertStatus(422)
            ->assertJsonValidationErrors("lastName");
    }

    public function test_last_name_invalid_string_422(): void {
        $this->valid["lastName"] = 123;
        $response = $this->postJson($this->route, $this->valid);
        $response->assertStatus(422)
            ->assertJsonValidationErrors("lastName");
    }

    public function test_phone_number_missing_422(): void {
        unset($this->valid["phoneNumber"]);
        $response = $this->postJson($this->route, $this->valid);
        $response->assertStatus(422)
            ->assertJsonValidationErrors("phoneNumber");
    }

    public function test_phone_number_invalid_string_422(): void {
        $this->valid["phoneNumber"] = 123;
        $response = $this->postJson($this->route, $this->valid);
        $response->assertStatus(422)
            ->assertJsonValidationErrors("phoneNumber");
    }

    public function test_phone_number_invalid_format_numbers_422(): void {
        $this->valid["phoneNumber"] = "1-234-567-89000";
        $response = $this->postJson($this->route, $this->valid);
        $response->assertStatus(422)
            ->assertJsonValidationErrors("phoneNumber");
    }

    public function test_phone_number_invalid_format_letters_422(): void {
        $this->valid["phoneNumber"] = "a-123-45b-678c";
        $response = $this->postJson($this->route, $this->valid);
        $response->assertStatus(422)
            ->assertJsonValidationErrors("phoneNumber");
    }

    public function test_phone_number_invalid_format_no_hyphen_422(): void {
        $this->valid["phoneNumber"] = "a-123-45b-678c";
        $response = $this->postJson($this->route, $this->valid);
        $response->assertStatus(422)
            ->assertJsonValidationErrors("phoneNumber");
    }
}
