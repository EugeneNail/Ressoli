<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreHouseRequest;
use App\Http\Requests\UpdateHouseRequest;
use App\Models\House;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class HouseController extends Controller {

    public function store(StoreHouseRequest $request) {
        $house = House::create($request->validated());

        return response()->json($house->id, Response::HTTP_CREATED);
    }

    public function update(UpdateHouseRequest $request, House $house) {
        if ($house === null) {
            abort(Response::HTTP_NOT_FOUND);
        }

        $house->update($request->validated());

        return response()->noContent();
    }
}
