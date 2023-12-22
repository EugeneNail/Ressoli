<?php

namespace Tests\Feature;

use App\Models\Application;
use Database\Seeders\GlobalOptionsSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class IndexApplicationsTest extends AuthorizedTestCase {

    public function setUp(): void {
        parent::setUp();
        $this->seed(GlobalOptionsSeeder::class);
        $this->route = "/api/applications";
        Application::factory()->withRandomApplicable()->count(25)->create();
    }

    public function test_get_no_types_200_all_applicables(): void {
        $response = $this->get($this->route);

        $applications = collect(json_decode($response->getContent())->data);
        $this->assertNotEmpty($applications);
        $hasAllTypes = collect($applications)
            ->map(fn ($application) => $application->applicable->type)
            ->unique()
            ->every(fn (string $value) => in_array($value, ["House", "Land Parcel", "Apartment"]));
        $this->assertTrue($hasAllTypes);
    }

    public function test_get_has_valid_structure(): void {
        $response = $this->get($this->route);
        $applications = collect(json_decode($response->getContent())->data);

        $applications->each(function ($application) {
            $this->assertObjectHasProperty("price", $application);
            $this->assertObjectHasProperty("hasMortgage", $application);
            $this->assertObjectHasProperty("contract", $application);
            $this->assertObjectHasProperty("isActive", $application);
            $this->assertObjectHasProperty("date", $application);
            $this->assertObjectHasProperty("client", $application);

            $this->assertObjectHasProperty("number", $application->address);
            $this->assertObjectHasProperty("street", $application->address);
            $this->assertObjectHasProperty("typeOfStreet", $application->address);
            $this->assertObjectHasProperty("city", $application->address);
            $this->assertObjectHasProperty("longitude", $application->address);
            $this->assertObjectHasProperty("latitude", $application->address);
        });

        $applications->where("applicable.type", "Land Parcel")->each(function ($application) {
            $this->assertObjectHasProperty("area", $application->applicable);
            $this->assertObjectHasProperty("hasWater", $application->applicable);
            $this->assertObjectHasProperty("hasGas", $application->applicable);
            $this->assertObjectHasProperty("hasElectricity", $application->applicable);
        });

        $applications->where("applicable.type", "House")->each(function ($application) {
            $this->assertObjectHasProperty("area", $application->applicable);
            $this->assertObjectHasProperty("landArea", $application->applicable);
            $this->assertObjectHasProperty("roomCount", $application->applicable);
        });

        $applications->where("applicable.type", "Apartment")->each(function ($application) {
            $this->assertObjectHasProperty("area", $application->applicable);
            $this->assertObjectHasProperty("level", $application->applicable);
            $this->assertObjectHasProperty("levelCount", $application->applicable);
            $this->assertObjectHasProperty("roomCount", $application->applicable);
        });
    }

    public function test_get_all_types_200_all_applicables(): void {
        $response = $this->get($this->route . "?types[]=houses&types[]=land-parcels&types[]=apartments");
        $applications = collect(json_decode($response->getContent())->data);

        $this->assertNotEmpty($applications);
        $hasAllTypes = collect($applications)
            ->map(fn ($application) => $application->applicable->type)
            ->unique()
            ->every(fn (string $value) => in_array($value, ["House", "Land Parcel", "Apartment"]));
        $this->assertTrue($hasAllTypes);
    }

    public function test_invalid_types_422(): void {
        $response = $this->getJson($this->route . "?types[]=house");

        $response->assertStatus(422);
    }

    public function test_get_houses_200(): void {
        $response = $this->get($this->route . "?types[]=houses");
        $applications = collect(json_decode($response->getContent())->data);
        $hasHousesOnly = collect($applications)->every(fn ($application) => $application->applicable->type === "House");

        $this->assertTrue($hasHousesOnly);
    }

    public function test_get_land_parcels_200(): void {
        $response = $this->get($this->route . "?types[]=land-parcels");
        $applications = collect(json_decode($response->getContent())->data);
        $hasLandParcelsOnly = collect($applications)->every(fn ($application) => $application->applicable->type === "Land Parcel");

        $this->assertTrue($hasLandParcelsOnly);
    }

    public function test_get_apartments_200(): void {
        $response = $this->get($this->route . "?types[]=apartments");
        $applications = collect(json_decode($response->getContent())->data);
        $hasLandParcelsOnly = collect($applications)->every(fn ($application) => $application->applicable->type === "Apartment");

        $this->assertTrue($hasLandParcelsOnly);
    }
}
