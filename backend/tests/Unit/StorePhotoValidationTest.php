<?php

namespace Tests\Unit;

use App\Http\Requests\StorePhotoRequest;
use Illuminate\Http\UploadedFile;

class StorePhotoValidationTest extends ValidationTestCase {

    public function setUp(): void {
        parent::setUp();
        $this->rules = (new StorePhotoRequest())->rules();
    }

    public function test_one_photo_success(): void {
        $files = [UploadedFile::fake()->image('avatar.jpg')->size(1024)];

        $this->assertTrue($this->validate(["photos", $files], ["photos.*", $files]));
    }

    public function test_multiple_photos_success(): void {
        $files = collect(range(1, rand(2, 10)))
            ->map(fn () => UploadedFile::fake()->image(uniqid() . ".jpg")->size(1024))
            ->toArray();

        $this->assertTrue($this->validate(["photos", $files], ["photos.*", $files]));
    }

    public function test_invalid_max_length_failure(): void {
        $files = collect(range(1, 16))
            ->map(fn () => UploadedFile::fake()->image(uniqid() . ".jpg")->size(1024))
            ->toArray();

        $this->assertFalse($this->validate(["photos", $files], ["photos.*", $files]));
    }

    public function test_no_data_failure(): void {
        $this->assertFalse($this->validate(["photos", null]));
    }

    public function test_invalid_max_size_failure(): void {
        $files = collect(range(1, rand(2, 10)))
            ->map(fn () => UploadedFile::fake()->image(uniqid() . ".jpg")->size(5 * 1024 + 1))
            ->toArray();

        $this->assertFalse($this->validate(["photos", $files], ["photos.*", $files]));
    }

    public function test_invalid_min_size_failure(): void {
        $files = collect(range(1, rand(2, 10)))
            ->map(fn () => UploadedFile::fake()->image(uniqid() . ".jpg")->size(32 - 1))
            ->toArray();

        $this->assertFalse($this->validate(["photos", $files], ["photos.*", $files]));
    }

    public function test_invalid_extension_failure(): void {
        $files = collect(range(1, rand(2, 10)))
            ->map(fn () => UploadedFile::fake()->create(uniqid() . ".pdf", 1024, "application/pdf"))
            ->toArray();

        $this->assertFalse($this->validate(["photos", $files], ["photos.*", $files]));
    }
}
