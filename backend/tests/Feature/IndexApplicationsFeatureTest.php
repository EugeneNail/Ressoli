<?php

namespace Tests\Feature;

use App\Models\Application;
use App\Models\Photo;
use App\Models\User;
use Database\Seeders\GlobalOptionsSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class IndexApplicationsFeatureTest extends AuthorizedTestCase {

    public function setUp(): void {
        parent::setUp();
        $this->seed(GlobalOptionsSeeder::class);
        $this->route = "/api/applications";
        Application::factory()->withRandomApplicable()->count(25)->create();
    }

    public function test_no_types_200_all_applicables(): void {
        $response = $this->get($this->route);

        $applications = collect(json_decode($response->getContent())->data);
        $this->assertNotEmpty($applications);
        $hasAllTypes = collect($applications)
            ->map(fn ($application) => $application->applicable->type)
            ->unique()
            ->every(fn (string $value) => in_array($value, ["House", "Land Parcel", "Apartment"]));
        $this->assertTrue($hasAllTypes);
    }

    public function test_has_valid_structure(): void {
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

    public function test_all_types_200_all_applicables(): void {
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

    public function test_houses_200(): void {
        $response = $this->getJson($this->route . "?types[]=houses");
        $response->assertStatus(200);
        $applications = collect(json_decode($response->getContent())->data);
        $hasHousesOnly = collect($applications)->every(fn ($application) => $application->applicable->type === "House");

        $this->assertTrue($hasHousesOnly);
    }

    public function test_land_parcels_200(): void {
        $response = $this->getJson($this->route . "?types[]=land-parcels");
        $response->assertStatus(200);
        $applications = collect(json_decode($response->getContent())->data);
        $hasLandParcelsOnly = collect($applications)->every(fn ($application) => $application->applicable->type === "Land Parcel");

        $this->assertTrue($hasLandParcelsOnly);
    }

    public function test_apartments_200(): void {
        $response = $this->getJson($this->route . "?types[]=apartments");
        $response->assertStatus(200);
        $applications = collect(json_decode($response->getContent())->data);
        $hasLandParcelsOnly = $applications->every(fn ($application) => $application->applicable->type === "Apartment");

        $this->assertTrue($hasLandParcelsOnly);
    }

    public function test_owned_200(): void {
        $response = $this->getJson($this->route . "?owned=true");
        $response->assertStatus(200);
        $hasOwnedOnly = collect(json_decode($response->getContent())->data)
            ->map(fn ($application) => Application::find($application->id))
            ->every(fn ($application) => $application["user_id"] === User::first()->id);
        $this->assertTrue($hasOwnedOnly);
    }

    public function test_empty_owned_200(): void {
        $response = $this->getJson($this->route);
        $response->assertStatus(200);
        $hasOwnedOnly = collect(json_decode($response->getContent())->data)
            ->map(fn ($application) => Application::find($application->id))
            ->every(fn ($application) => $application["user_id"] === User::first()->id);
        $this->assertFalse($hasOwnedOnly);
    }

    public function test_all_statuses_200(): void {
        $response = $this->getJson($this->route);
        $response->assertStatus(200);
        $hasAllStatuses = collect(json_decode($response->getContent())->data)
            ->every(fn ($application) => $application->isActive === true || $application->isActive === false);
        $this->assertTrue($hasAllStatuses);
    }

    public function test_active_200(): void {
        $response = $this->getJson($this->route . "?status=Active");
        $response->assertStatus(200);
        $hasActiveOnly = collect(json_decode($response->getContent())->data)
            ->every(fn ($application) => $application->isActive === true);
        $this->assertTrue($hasActiveOnly);
    }

    public function test_archived_200(): void {
        $response = $this->getJson($this->route . "?status=Archived");
        $response->assertStatus(200);
        $hasArchivedOnly = collect(json_decode($response->getContent())->data)
            ->every(fn ($application) => $application->isActive == false);
        $this->assertTrue($hasArchivedOnly);
    }

    public function test_min_price_200(): void {
        $price = 1000000;
        $response = $this->getJson($this->route . "?min-price={$price}");
        $response->assertStatus(200);
        $hasAboveMinPriceOnly = collect(json_decode($response->getContent())->data)
            ->every(fn ($application) => $application->price >= $price);
        $this->assertTrue($hasAboveMinPriceOnly);
    }

    public function test_max_price_200(): void {
        $price = 1000000;
        $response = $this->getJson($this->route . "?max-price={$price}");
        $response->assertStatus(200);
        $hasBelowMaxPriceOnly = collect(json_decode($response->getContent())->data)
            ->every(fn ($application) => $application->price <= $price);
        $this->assertTrue($hasBelowMaxPriceOnly);
    }

    public function test_min_area_200(): void {
        $area = 1000;
        $response = $this->getJson($this->route . "?min-area={$area}");
        $response->assertStatus(200);
        $hasAboveMinAreaOnly = collect(json_decode($response->getContent())->data)
            ->every(fn ($application) => $application->applicable->area >= $area);
        $this->assertTrue($hasAboveMinAreaOnly);
    }

    public function test_max_area_200(): void {
        $area = 5000;
        $response = $this->getJson($this->route . "?max-area={$area}");
        $response->assertStatus(200);
        $hasBelowMaxAreaOnly = collect(json_decode($response->getContent())->data)
            ->every(fn ($application) => $application->applicable->area <= $area);
        $this->assertTrue($hasBelowMaxAreaOnly);
    }

    public function test_sales_200(): void {
        $response = $this->getJson($this->route . "?contract=Sale");
        $response->assertStatus(200);
        $hasSaleOnly = collect(json_decode($response->getContent())->data)
            ->every(fn ($application) => $application->contract === "Sale");
        $this->assertTrue($hasSaleOnly);
    }

    public function test_rents_200(): void {
        $response = $this->getJson($this->route . "?contract=Rent");
        $response->assertStatus(200);
        $hasRentOnly = collect(json_decode($response->getContent())->data)
            ->every(fn ($application) => $application->contract === "Rent");
        $this->assertTrue($hasRentOnly);
    }

    public function test_empty_contracts_200(): void {
        $response = $this->getJson($this->route);
        $response->assertStatus(200);
        $hasAllContracts = collect(json_decode($response->getContent())->data)
            ->every(fn ($application) => $application->contract === "Sale" || $application->contract === "Rent");
        $this->assertTrue($hasAllContracts);
    }

    public function test_after_date_200(): void {
        Application::factory()
            ->withRandomApplicable()
            ->withRandomDate(365)
            ->count(100)
            ->create();
        $date = "2024-06-30";
        $response = $this->getJson($this->route . "?min-date={$date}");
        $response->assertStatus(200);
        $hasAfterDateOnly = collect(json_decode($response->getContent())->data)
            ->every(fn ($application) => strtotime($application->date) > strtotime($date));
        $this->assertTrue($hasAfterDateOnly);
    }

    public function test_before_date_200(): void {
        Application::factory()
            ->withRandomApplicable()
            ->withRandomDate(365)
            ->count(100)
            ->create();
        $date = "2024-06-30";
        $response = $this->getJson($this->route . "?max-date={$date}");
        $response->assertStatus(200);
        $hasBeforeDateOnly = collect(json_decode($response->getContent())->data)
            ->every(fn ($application) => strtotime($application->date) < strtotime($date));
        $this->assertTrue($hasBeforeDateOnly);
    }

    public function test_no_photos_200(): void {
        Application::factory()
            ->withRandomApplicable()
            ->count(20)
            ->has(Photo::factory(3))
            ->create();
        $response = $this->getJson($this->route . "?no-photos=true");
        $response->assertStatus(200);
        $hasNoPhotosOnly = collect(json_decode($response->getContent())->data)
            ->every(fn ($application) => $application->preview === null);
        $this->assertTrue($hasNoPhotosOnly);
    }
}
