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

    public function update(UpdateHouseRequest $request, int $id) {
        $house = House::find($id);

        if (is_null($house)) {
            return new JsonResponse(["message" => "The house not found"], Response::HTTP_NOT_FOUND);
        }

        $data = $request->validated();
        $house->update($data);

        return new JsonResponse(null, Response::HTTP_NO_CONTENT);
    }
}
