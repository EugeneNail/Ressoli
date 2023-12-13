<?php

namespace Database\Seeders;

use App\Models\Address;
use App\Models\Option;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;

class AddressOptionsSeeder extends Seeder {

    public function run(): void {
        DB::table("options")->truncate();
        Option::insert([
            ["type" => Address::class, "name" => "type_of_street", "value" => "Aly"],
            ["type" => Address::class, "name" => "type_of_street", "value" => "Ave"],
            ["type" => Address::class, "name" => "type_of_street", "value" => "Blvd"],
            ["type" => Address::class, "name" => "type_of_street", "value" => "Dr"],
            ["type" => Address::class, "name" => "type_of_street", "value" => "Ln"],
            ["type" => Address::class, "name" => "type_of_street", "value" => "Rd"],
            ["type" => Address::class, "name" => "type_of_street", "value" => "St"],
            ["type" => Address::class, "name" => "type_of_street", "value" => "Way"],
        ]);
    }
}
