<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreHouseRequest;
use App\Http\Requests\UpdateHouseRequest;
use App\Models\House;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class HouseController extends Controller {

    public function store(StoreHouseRequest $request) {
        $data = $request->validated();
        $house = House::create($data);

        return new JsonResponse($house->id, Response::HTTP_CREATED);
    }
}
