<?php

namespace App\Actions;

use App\Models\Option;

class GetOptions {
    public function run(string $type): array {
        return Option::where("type", $type)
            ->select("name", "value")
            ->get()
            ->groupBy("name")
            ->map(fn ($collection) => $collection->pluck("value"))
            ->toArray();
    }
}
