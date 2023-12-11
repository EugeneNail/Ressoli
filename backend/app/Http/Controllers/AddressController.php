<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreAddressRequest;
use App\Models\Address;
use App\Services\GeocodingInterface;
use App\Services\HereGeocoding;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Http;

class AddressController extends Controller {

    public function store(StoreAddressRequest $request, GeocodingInterface $geocoding) {
        $data = $request->safe();
        $address = Address::where("postal_code", $data->postal_code)
            ->where("number", $data->number)
            ->where("unit", $data->unit)
            ->where("street", $data->street)
            ->where("type_of_street", $data->type_of_street)
            ->where("city", $data->city)
            ->first();


        if ($address) {
            return new JsonResponse($address->id, Response::HTTP_OK);
        }

        $address = new Address($data->toArray());
        $position = $geocoding->geocode($address);

        if (!$position) {
            return new JsonResponse(
                ["message" => "Unable to locate the object on the map"],
                Response::HTTP_NOT_FOUND
            );
        }

        $address
            ->fill(["latitude" => $position->latitude, "longitude" => $position->longitude])
            ->save();

        return new JsonResponse($address->id, Response::HTTP_CREATED);
    }
}
