<?php

namespace App\Models\Support;

class Position {

    public readonly float $latitude;

    public readonly float $longitude;

    public function __construct(float $latitude, float $longitude) {
        $this->latitude = $latitude;
        $this->longitude = $longitude;
    }
}
