<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreApartmentRequest;
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
}
