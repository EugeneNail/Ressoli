<?php

namespace App\Services;

use App\Models\Address;
use App\Models\Support\Position;

interface GeocodingInterface {

    public function geocode(Address $address): Position | false;

    public function geocodeReverse(Position $position): Address | false;
}
