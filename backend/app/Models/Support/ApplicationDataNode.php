<?php

namespace App\Models\Support;

class ApplicationDataNode {

    readonly public string $name;

    readonly public int|float $active;

    readonly public int|float $archived;

    readonly public int|float $price;

    public function __construct(string $name, int|float $active, int|float $archived, int|float $price = 0) {
        $this->name = $name;
        $this->active = $active;
        $this->archived = $archived;
        $this->price = $price;
    }
}
