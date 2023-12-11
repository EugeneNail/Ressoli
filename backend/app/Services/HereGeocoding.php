<?php

namespace App\Services;

use App\Models\Address;
use App\Models\Support\Position;
use Illuminate\Support\Facades\Http;
use Nette\NotImplementedException;

class HereGeocoding implements GeocodingInterface {

    private const ENDPOINT = "https://geocode.search.hereapi.com/v1/geocode";

    public function geocode(Address $address): Position | false {
        $response = Http::get(self::ENDPOINT . $this->buildQuery($address));

        if (empty($response->object()->items) || !$response->ok()) {
            return false;
        }

        $herePosition = $response->object()->items[0]->position;

        return new Position($herePosition->lat, $herePosition->lng);
    }

    public function geocodeReverse(Position $position): Address {
        throw new NotImplementedException();
    }

    public function buildQuery(Address $address): string {
        $query = "?qq=";
        $query .= "city=" . $address->city;
        $query .= ";street=" . $address->street . " " . $address->type_of_street;
        $query .= ";houseNumber=" . $address->number;

        if ($address->postal_code != null) {
            $query .= ";postalCode=" .  $address->postal_code;
        }

        $query .= "&limit=1";
        $query .= "&apiKey=" . env("HERE_API_KEY");

        return $query;
    }
}
