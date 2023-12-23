<?php

namespace Tests\Unit;

use Database\Seeders\GlobalOptionsSeeder;
use PHPUnit\Framework\TestCase;
use Tests\Feature\AuthorizedTestCase;

class IndexApplicableOptionsValidationTest extends AuthorizedTestCase {

    public function setUp(): void {
        parent::setUp();
        $this->seed(GlobalOptionsSeeder::class);
        $this->route = "/api/options";
    }

    public function test_index_invalid_applicable_422(): void {
        $response = $this->getJson($this->route . "/house");

        $response->assertStatus(404);
    }

    public function test_index_address_200_valid_structure(): void {
        $response = $this->getJson($this->route . "/addresses");

        $response->assertStatus(200);
        $response->assertJsonStructure([
            "typeOfStreet",
        ]);
    }

    public function test_index_land_parcel_200_valid_structure(): void {
        $response = $this->getJson($this->route . "/land-parcels");

        $response->assertStatus(200);
        $response->assertJsonStructure([
            "water",
            "gas",
            "electricity",
            "sewer",
        ]);
    }

    public function test_index_house_200_valid_structure(): void {
        $response = $this->getJson($this->route . "/houses");

        $response->assertStatus(200);
        $response->assertJsonStructure([
            "water",
            "gas",
            "sewer",
            "electricity",
            "hotWater",
            "walls",
            "condition",
            "bathroom",
            "heating",
            "bath",
            "roof",
            "floor",
        ]);
    }

    public function test_index_apartment_200_valid_structure(): void {
        $response = $this->getJson($this->route . "/apartments");

        $response->assertStatus(200);
        $response->assertJsonStructure([
            "walls",
            "condition",
            "bath",
            "bathroom"
        ]);
    }
}
