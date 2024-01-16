<?php

namespace App\Services;

use App\Models\Address;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class AddressManagement {

    public function findDuplicate(Request $request): Address | null {
        $data = $request->safe();

        return Address::where("postal_code", $data->postal_code)
            ->where("number", $data->number)
            ->where("unit", $data->unit)
            ->where("street", $data->street)
            ->where("type_of_street", $data->type_of_street)
            ->where("city", $data->city)
            ->first();
    }


    public function locateOrFail(Address $address, GeocodingInterface $geocoding) {
        $position = $geocoding->geocode($address);

        if (!$position) {
            abort(Response::HTTP_NOT_FOUND, "Unable to locate the address");
        }

        $address->fill([
            "latitude" => $position->latitude,
            "longitude" => $position->longitude
        ]);
    }
}
