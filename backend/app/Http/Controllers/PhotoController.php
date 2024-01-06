<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePhotoRequest;
use App\Models\Photo;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;

class PhotoController extends Controller {

    public function __invoke(StorePhotoRequest $request) {
        $photos = [];

        foreach ($request->file("photos") as $file) {
            $path = $file->store("photos/temp", "local");
            $photos[] = Photo::create(["path" => $path]);
        }

        return response()->json($photos, Response::HTTP_CREATED);
    }
}
