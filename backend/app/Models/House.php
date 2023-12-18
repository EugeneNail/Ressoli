<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphOne;

class House extends Model {
    use HasFactory;

    protected $fillable = [
        "water",
        "gas",
        "electricity",
        "sewer",
        "condition",
        "walls",
        "roof",
        "floor",
        "level_count",
        "has_garage",
        "hot_water",
        "heating",
        "bath",
        "bathroom",
        "room_count",
        "area",
        "kitchen_area",
        "land_area",
    ];

    protected $casts = [
        "has_garage" => "boolean"
    ];

    public function application(): MorphOne {
        return $this->morphOne(Application::class, "applicable");
    }
}
