<?php

namespace Database\Seeders;

use App\Models\House;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class HouseOptionsSeeder extends Seeder {

    public function run(): void {
        DB::table("options")->insert([
            ["type" => House::class, "name" => "water", "value" => "None"],
            ["type" => House::class, "name" => "water", "value" => "Central water supply"],
            ["type" => House::class, "name" => "water", "value" => "Well"],
            ["type" => House::class, "name" => "water", "value" => "On the border"],
            ["type" => House::class, "name" => "water", "value" => "Nearby"],
            ["type" => House::class, "name" => "gas", "value" => "None"],
            ["type" => House::class, "name" => "gas", "value" => "Central gas supply"],
            ["type" => House::class, "name" => "gas", "value" => "Gas holder"],
            ["type" => House::class, "name" => "gas", "value" => "On the border"],
            ["type" => House::class, "name" => "gas", "value" => "Nearby"],
            ["type" => House::class, "name" => "sewer", "value" => "None"],
            ["type" => House::class, "name" => "sewer", "value" => "Central"],
            ["type" => House::class, "name" => "sewer", "value" => "Cesspool"],
            ["type" => House::class, "name" => "sewer", "value" => "Septic tank"],
            ["type" => House::class, "name" => "sewer", "value" => "On the border"],
            ["type" => House::class, "name" => "sewer", "value" => "Nearby"],
            ["type" => House::class, "name" => "electricity", "value" => "None"],
            ["type" => House::class, "name" => "electricity", "value" => "Overhead line"],
            ["type" => House::class, "name" => "electricity", "value" => "Underground cable"],
            ["type" => House::class, "name" => "electricity", "value" => "On the border"],
            ["type" => House::class, "name" => "electricity", "value" => "Nearby"],
            ["type" => House::class, "name" => "hot_water", "value" => "None"],
            ["type" => House::class, "name" => "hot_water", "value" => "Boiler"],
            ["type" => House::class, "name" => "hot_water", "value" => "CHP"],
            ["type" => House::class, "name" => "walls", "value" => "Brick"],
            ["type" => House::class, "name" => "walls", "value" => "Panel"],
            ["type" => House::class, "name" => "walls", "value" => "Monolithic"],
            ["type" => House::class, "name" => "walls", "value" => "Monolithic-brick"],
            ["type" => House::class, "name" => "walls", "value" => "Frame-monolithic"],
            ["type" => House::class, "name" => "walls", "value" => "Panel-brick"],
            ["type" => House::class, "name" => "walls", "value" => "Block"],
            ["type" => House::class, "name" => "condition", "value" => "Euro"],
            ["type" => House::class, "name" => "condition", "value" => "Excellent"],
            ["type" => House::class, "name" => "condition", "value" => "Good"],
            ["type" => House::class, "name" => "condition", "value" => "Habitable"],
            ["type" => House::class, "name" => "condition", "value" => "Cosmetic repair required"],
            ["type" => House::class, "name" => "condition", "value" => "Major repair required"],
            ["type" => House::class, "name" => "condition", "value" => "Without interior finishing"],
            ["type" => House::class, "name" => "bathroom", "value" => "None"],
            ["type" => House::class, "name" => "bathroom", "value" => "Separate"],
            ["type" => House::class, "name" => "bathroom", "value" => "Combined"],
            ["type" => House::class, "name" => "heating", "value" => "None"],
            ["type" => House::class, "name" => "heating", "value" => "Gas boiler"],
            ["type" => House::class, "name" => "heating", "value" => "Stove"],
            ["type" => House::class, "name" => "heating", "value" => "CHP"],
            ["type" => House::class, "name" => "heating", "value" => "Injector"],
            ["type" => House::class, "name" => "heating", "value" => "Electric"],
            ["type" => House::class, "name" => "bath", "value" => "None"],
            ["type" => House::class, "name" => "bath", "value" => "Standard"],
            ["type" => House::class, "name" => "bath", "value" => "Sitting"],
            ["type" => House::class, "name" => "bath", "value" => "Shower"],
            ["type" => House::class, "name" => "bath", "value" => "Shower cabin"],
            ["type" => House::class, "name" => "roof", "value" => "None"],
            ["type" => House::class, "name" => "roof", "value" => "Metal tile"],
            ["type" => House::class, "name" => "roof", "value" => "Soft roof"],
            ["type" => House::class, "name" => "roof", "value" => "Ondulin"],
            ["type" => House::class, "name" => "roof", "value" => "Profiled sheet"],
            ["type" => House::class, "name" => "roof", "value" => "Shingle"],
            ["type" => House::class, "name" => "roof", "value" => "Slate"],
            ["type" => House::class, "name" => "floor", "value" => "None"],
            ["type" => House::class, "name" => "floor", "value" => "Hardwood"],
            ["type" => House::class, "name" => "floor", "value" => "Laminate"],
            ["type" => House::class, "name" => "floor", "value" => "Tile"],
            ["type" => House::class, "name" => "floor", "value" => "Linoleum"],
            ["type" => House::class, "name" => "floor", "value" => "Carpeting"],
            ["type" => House::class, "name" => "floor", "value" => "Stone"],
            ["type" => House::class, "name" => "floor", "value" => "Concrete"],
        ]);
    }
}
