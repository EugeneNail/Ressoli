<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreAddressRequest;
use App\Models\Address;
use App\Services\AddressManagement;
use App\Services\GeocodingInterface;
use App\Services\HereGeocoding;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Http;

class AddressController extends Controller {

    public function store(StoreAddressRequest $request, GeocodingInterface $geocoding, AddressManagement $management) {
        $duplicate = $management->findDuplicate($request);

        if ($duplicate) {
            return response()->json($duplicate->id, Response::HTTP_OK);
        }

        $address = new Address($request->validated());
        $management->locateOrFail($address, $geocoding);
        $address->save();

        return response()->json($address->id, Response::HTTP_CREATED);
    }
}
