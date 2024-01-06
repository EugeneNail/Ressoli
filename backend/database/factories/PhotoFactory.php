<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Http\UploadedFile;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Photo>
 */
class PhotoFactory extends Factory {
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array {
        $width = fake()->numberBetween(128, 2048);
        $height = fake()->numberBetween(128, 2048);
        $size = fake()->numberBetween(32, 5 * 1024);
        $file = UploadedFile::fake()->image(uniqid() . ".jpg", $width, $height)->size($size);

        $path = $file->store("photos/temp", "local");

        return [
            "path" => $path,
        ];
    }
}
