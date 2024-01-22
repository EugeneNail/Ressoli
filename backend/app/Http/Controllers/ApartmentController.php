<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreApartmentRequest;
use App\Http\Requests\UpdateApartmentRequest;
use App\Models\Apartment;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ApartmentController extends Controller {

    public function store(StoreApartmentRequest $request) {
        $apartment = Apartment::create($request->validated());

        return response()->json($apartment->id, Response::HTTP_CREATED);
    }

    public function update(UpdateApartmentRequest $request, Apartment $apartment) {
        $apartment->update($request->validated());

        return response()->noContent();
    }
}
