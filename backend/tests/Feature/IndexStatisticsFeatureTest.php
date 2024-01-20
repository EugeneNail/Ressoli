<?php

namespace Tests\Feature;

use App\Models\Apartment;
use App\Models\Application;
use App\Models\House;
use App\Models\LandParcel;
use App\Models\Support\ApplicationDataNode;
use App\Models\User;
use Database\Seeders\GlobalOptionsSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Event;
use Tests\TestCase;

class IndexStatisticsFeatureTest extends AuthorizedTestCase {

    use RefreshDatabase;

    public function setUp(): void {
        parent::setUp();
        $this->route = "/api/statistics";
        $user = User::first();
        $this->seed(GlobalOptionsSeeder::class);
        Application::factory()
            ->withUser($user)
            ->withRandomApplicable()
            ->withRandomDate(365)
            ->count(200)
            ->create();
    }


    public function test_structure_200(): void {
        $response = $this->get($this->route);

        $response->assertStatus(200);
        $response->assertJsonStructure([
            "currentMonth" => [
                "*" => [
                    "name",
                    "active",
                    "archived",
                    "price"
                ]
            ],
            "monthly" => [
                "*" => [
                    "name",
                    "active",
                    "archived",
                    "price"
                ]
            ]
        ]);
    }


    public function test_max_month_is_greater_or_equal_the_current_month_200(): void {
        $currentMonth = (int) date('n');
        $response = $this->get($this->route);
        $content = json_decode($response->getContent());


        $response->assertStatus(200);
        $this->assertCount($currentMonth, $content->monthly);
        for ($month = 1; $month <= $currentMonth; $month++) {
            $this->assertEquals($content->monthly[$month - 1]->name, $month);
        }
    }


    public function test_collected_current_month_statistics_matches_the_expected(): void {
        $response = $this->get($this->route);
        $content = json_decode($response->getContent());
        $map = [
            "Houses" => House::class,
            "Apartments" => Apartment::class,
            "Parcels" => LandParcel::class
        ];

        foreach ($content->currentMonth as $node) {
            $query = Application::query()
                ->where("user_id", User::first()->id)
                ->where("applicable_type", $map[$node->name])
                ->whereDate("created_at", ">=", date("Y-m-01") . " 00:00:00")
                ->whereDate("created_at", "<=", date("Y-m-t") . " 23:59:59");
            $active = $query->clone()->where("is_active", true)->count();
            $archived = $query->clone()->where("is_active", false)->count();
            $price = $query->where("is_active", false)->sum("price");

            $this->assertEquals($node->active, $active);
            $this->assertEquals($node->archived, $archived);
            $this->assertEquals($node->price, $price);
        }
    }


    public function test_collected_monthly_statistics_matches_the_expected(): void {
        $response = $this->get($this->route);

        $content = json_decode($response->getContent());
        foreach ($content->monthly as $node) {
            $query = Application::query()
                ->where("user_id", User::first()->id)
                ->whereDate("created_at", ">=", date("Y-01-01" . " 00:00:00"))
                ->whereDate("created_at", "<=", date("Y-01-t") . " 23:59:59");
            $active = $query->clone()->where("is_active", true)->count();
            $archived = $query->clone()->where("is_active", false)->count();
            $price = $query->where("is_active", false)->sum("price");

            $this->assertEquals($node->active, $active);
            $this->assertEquals($node->archived, $archived);
            $this->assertEquals($node->price, $price);
        }
    }


    public function test_mocked_time_max_month_is_greater_or_equal_the_current_month_200(): void {
        $this->travel(rand(0, 12))->months();
        $currentMonth = (int) date('n');
        $response = $this->get($this->route);
        $content = json_decode($response->getContent());


        $response->assertStatus(200);
        $this->assertCount($currentMonth, $content->monthly);
        for ($month = 1; $month <= $currentMonth; $month++) {
            $this->assertEquals($content->monthly[$month - 1]->name, $month);
        }
    }


    public function test_mocked_time_collected_current_month_statistics_matches_the_expected(): void {
        $this->travel(rand(0, 12))->months();
        $response = $this->get($this->route);
        $content = json_decode($response->getContent());
        $map = [
            "Houses" => House::class,
            "Apartments" => Apartment::class,
            "Parcels" => LandParcel::class
        ];

        foreach ($content->currentMonth as $node) {
            $query = Application::query()
                ->where("user_id", User::first()->id)
                ->where("applicable_type", $map[$node->name])
                ->whereDate("created_at", ">=", date("Y-m-01") . " 00:00:00")
                ->whereDate("created_at", "<=", date("Y-m-t") . " 23:59:59");
            $active = $query->clone()->where("is_active", true)->count();
            $archived = $query->clone()->where("is_active", false)->count();
            $price = $query->where("is_active", false)->sum("price");

            $this->assertEquals($node->active, $active);
            $this->assertEquals($node->archived, $archived);
            $this->assertEquals($node->price, $price);
        }
    }


    public function test_mocked_time_collected_monthly_statistics_matches_the_expected(): void {
        $this->travel(rand(0, 12))->months();
        $response = $this->get($this->route);

        $content = json_decode($response->getContent());
        foreach ($content->monthly as $node) {
            $query = Application::query()
                ->where("user_id", User::first()->id)
                ->whereDate("created_at", ">=", date("Y-01-01" . " 00:00:00"))
                ->whereDate("created_at", "<=", date("Y-01-t") . " 23:59:59");
            $active = $query->clone()->where("is_active", true)->count();
            $archived = $query->clone()->where("is_active", false)->count();
            $price = $query->where("is_active", false)->sum("price");

            $this->assertEquals($node->active, $active);
            $this->assertEquals($node->archived, $archived);
            $this->assertEquals($node->price, $price);
        }
    }
}
