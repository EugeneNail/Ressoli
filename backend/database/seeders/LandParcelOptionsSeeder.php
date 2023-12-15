<?php

namespace Database\Seeders;

use App\Models\LandParcel;
use App\Models\Option;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LandParcelOptionsSeeder extends Seeder {

    public function run(): void {
        DB::table("options")->insert([
            ["type" => LandParcel::class, "name" => "water", "value" => "None"],
            ["type" => LandParcel::class, "name" => "water", "value" => "Central water supply"],
            ["type" => LandParcel::class, "name" => "water", "value" => "Well"],
            ["type" => LandParcel::class, "name" => "water", "value" => "On the boundary"],
            ["type" => LandParcel::class, "name" => "water", "value" => "Nearby"],
            ["type" => LandParcel::class, "name" => "gas", "value" => "None"],
            ["type" => LandParcel::class, "name" => "gas", "value" => "Central gas supply"],
            ["type" => LandParcel::class, "name" => "gas", "value" => "Gas holder"],
            ["type" => LandParcel::class, "name" => "gas", "value" => "On the boundary"],
            ["type" => LandParcel::class, "name" => "gas", "value" => "Nearby"],
            ["type" => LandParcel::class, "name" => "sewer", "value" => "None"],
            ["type" => LandParcel::class, "name" => "sewer", "value" => "Central sewer system"],
            ["type" => LandParcel::class, "name" => "sewer", "value" => "Cesspool"],
            ["type" => LandParcel::class, "name" => "sewer", "value" => "Septic tank"],
            ["type" => LandParcel::class, "name" => "sewer", "value" => "On the boundary"],
            ["type" => LandParcel::class, "name" => "sewer", "value" => "Nearby"],
            ["type" => LandParcel::class, "name" => "electricity", "value" => "None"],
            ["type" => LandParcel::class, "name" => "electricity", "value" => "Overhead line"],
            ["type" => LandParcel::class, "name" => "electricity", "value" => "Underground cable"],
            ["type" => LandParcel::class, "name" => "electricity", "value" => "On the boundary"],
            ["type" => LandParcel::class, "name" => "electricity", "value" => "Nearby"],
        ]);
    }
}
