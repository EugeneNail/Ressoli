<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreLandParcelRequest;
use App\Http\Requests\UpdateLandParcelRequest;
use App\Models\LandParcel;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class LandParcelController extends Controller {

    public function store(StoreLandParcelRequest $request) {
        $data = $request->validated();
        $landParcel = LandParcel::create($data);

        return new JsonResponse($landParcel->id, Response::HTTP_CREATED);
    }

    public function update(UpdateLandParcelRequest $request, int $id) {
        $landParcel = LandParcel::find($id);

        if (is_null($landParcel)) {
            return new JsonResponse(["message" => "The land parcel not found"], Response::HTTP_NOT_FOUND);
        }

        $data = $request->validated();
        $landParcel->update($data);

        return new JsonResponse(null, Response::HTTP_NO_CONTENT);
    }
}
