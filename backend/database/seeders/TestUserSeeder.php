<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Laravel\Sanctum\PersonalAccessToken;

class TestUserSeeder extends Seeder {
    /**
     * Run the database seeds.
     */
    public function run(): void {
        $user = User::create([
            "name" => "Jonh",
            "lastName" => "Doe",
            "email" => "john.doe@gmail.com",
            "password" => '$2y$04$kIh5dqu6ma07bcm.ku9lyeeHjvNlNhzishw9kRMaQMicmkA3HKZZm'
        ]);

        //The plain text token is 1|3t0ix4PEXkDOgssDYkqZDo9i7ynEhcxgWI159aBHc3e24611
        PersonalAccessToken::create([
            "name" => "127.0.0.1",
            "tokenable_type" => User::class,
            "tokenable_id" => $user->id,
            "token" => "a145676ab6f4e7892ec02fefec3cd804fcb83cd5eabfb40c8e97aec9fea70234"
        ]);
    }
}
