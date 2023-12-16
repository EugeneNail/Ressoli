<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
}
