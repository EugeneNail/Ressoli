<?php

namespace Tests\Feature;

use App\Http\Requests\StorePhotoRequest;
use App\Models\Photo;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class StorePhotoTest extends AuthorizedTestCase {

    use RefreshDatabase;

    public function setUp(): void {
        parent::setUp();
        $photos = collect(range(1, rand(2, 10)))
            ->map(fn ($name) => UploadedFile::fake()->image("{$name}.jpg")->size(1024))
            ->toArray();
        $this->data = ["photos" => $photos];
        $this->route = "/api/photos";
    }

    public function tearDown(): void {
        $files = Storage::disk("local")->allFiles("photos/temp");
        Storage::disk("local")->delete($files);
    }

    public function test_store_one_photo_201(): void {
        $this->data = ["photos" => [UploadedFile::fake()->image("test.jpg")->size(1024)]];
        $response = $this->postJson($this->route, $this->data);

        $response->assertStatus(201);
        $this->assertDatabaseCount(Photo::class, 1);

        Photo::all()->each(function ($photo) {
            $this->assertStringContainsString("photos/temp/", $photo->path);
            $this->assertTrue(Storage::disk("local")->exists($photo->path));
        });
    }

    public function test_store_multiple_photos_201(): void {
        $response = $this->postJson($this->route, $this->data);

        $response->assertStatus(201);
        $this->assertDatabaseCount(Photo::class, count($this->data["photos"]));

        Photo::all()->each(function ($photo) {
            $this->assertStringContainsString("photos/temp/", $photo->path);
            $this->assertTrue(Storage::disk("local")->exists($photo->path));
        });
    }

    public function test_store_invalid_data_failure_422(): void {
        $this->data["photos"][] = UploadedFile::fake()->create(uniqid() .  ".pdf", 1024, "application/pdf");
        $response = $this->postJson($this->route, $this->data);

        $response->assertStatus(422);
    }
}
