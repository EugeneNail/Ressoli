<?php

namespace Database\Seeders;

use App\Models\Application;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ApplicationOptionsSeeder extends Seeder {
    /**
     * Run the database seeds.
     */
    public function run(): void {
        DB::table("options")->insert([
            ["type" => Application::class, "name" => "contract", "value" => "Sale"],
            ["type" => Application::class, "name" => "contract", "value" => "Rent"]
        ]);
    }
}
