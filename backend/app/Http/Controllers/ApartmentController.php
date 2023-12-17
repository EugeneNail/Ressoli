<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreApartmentRequest;
use App\Http\Requests\UpdateApartmentRequest;
use App\Models\Apartment;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ApartmentController extends Controller {

    public function store(StoreApartmentRequest $request) {
        $data = $request->validated();
        $apartment = Apartment::create($data);

        return new JsonResponse($apartment->id, Response::HTTP_CREATED);
    }

    public function update(UpdateApartmentRequest $request, int $id) {
        $apartment = Apartment::find($id);

        if (is_null($apartment)) {
            return new JsonResponse("The apartment not found", Response::HTTP_NOT_FOUND);
        }
        $data = $request->validated();
        $apartment->update($data);

        return new JsonResponse(null, Response::HTTP_NO_CONTENT);
    }
}
