<?php

namespace Database\Seeders;

use App\Models\Apartment;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ApartmentOptionsSeeder extends Seeder {
    /**
     * Run the database seeds.
     */
    public function run(): void {
        DB::table("options")->insert([
            ["type" => Apartment::class, "name" => "walls", "value" => "Brick"],
            ["type" => Apartment::class, "name" => "walls", "value" => "Panel"],
            ["type" => Apartment::class, "name" => "walls", "value" => "Monolithic"],
            ["type" => Apartment::class, "name" => "walls", "value" => "Monolithic Brick"],
            ["type" => Apartment::class, "name" => "walls", "value" => "Frame-Monolithic"],
            ["type" => Apartment::class, "name" => "walls", "value" => "Panel-Brick"],
            ["type" => Apartment::class, "name" => "walls", "value" => "Block"],
            ["type" => Apartment::class, "name" => "condition", "value" => "Euro"],
            ["type" => Apartment::class, "name" => "condition", "value" => "Excellent"],
            ["type" => Apartment::class, "name" => "condition", "value" => "Good"],
            ["type" => Apartment::class, "name" => "condition", "value" => "Habitable"],
            ["type" => Apartment::class, "name" => "condition", "value" => "Needs Cosmetic Repair"],
            ["type" => Apartment::class, "name" => "condition", "value" => "Needs Major Repair"],
            ["type" => Apartment::class, "name" => "condition", "value" => "Without Interior Finishing"],
            ["type" => Apartment::class, "name" => "bath", "value" => "None"],
            ["type" => Apartment::class, "name" => "bath", "value" => "Standard"],
            ["type" => Apartment::class, "name" => "bath", "value" => "Sitting"],
            ["type" => Apartment::class, "name" => "bath", "value" => "Shower"],
            ["type" => Apartment::class, "name" => "bath", "value" => "Shower Cabin"],
            ["type" => Apartment::class, "name" => "bathroom", "value" => "None"],
            ["type" => Apartment::class, "name" => "bathroom", "value" => "Separate"],
            ["type" => Apartment::class, "name" => "bathroom", "value" => "Combined"]
        ]);
    }
}
