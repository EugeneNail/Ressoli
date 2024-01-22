<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreLandParcelRequest;
use App\Http\Requests\UpdateLandParcelRequest;
use App\Models\LandParcel;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class LandParcelController extends Controller {

    public function store(StoreLandParcelRequest $request) {
        $landParcel = LandParcel::create($request->validated());

        return response()->json($landParcel->id, Response::HTTP_CREATED);
    }

    public function update(UpdateLandParcelRequest $request, LandParcel $landParcel) {
        $landParcel->update($request->validated());

        return response()->noContent();
    }
}
