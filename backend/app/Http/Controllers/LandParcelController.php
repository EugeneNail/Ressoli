<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreLandParcelRequest;
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
}
