<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Foundation\Testing\RefreshDatabase;

class StaticDataSeeder extends Seeder {

    use WithoutModelEvents;
    use RefreshDatabase;

    public function run(): void {
        $this->call(AddressOptionsSeeder::class);
        $this->call(LandParcelOptionsSeeder::class);
        $this->call(HouseOptionsSeeder::class);
        $this->call(ApartmentOptionsSeeder::class);
    }
}
