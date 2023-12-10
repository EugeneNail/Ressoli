<?php

namespace Database\Seeders;

use App\Models\Client;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TestClientSeeder extends Seeder {
    /**
     * Run the database seeds.
     */
    public function run(): void {
        Client::create([
            "id" => 1,
            "name" => "John",
            "last_name" => "Doe",
            "phone_number" => "1-234-567-8900"
        ]);
    }
}
