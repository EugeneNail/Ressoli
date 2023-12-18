<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphOne;

class Apartment extends Model {
    use HasFactory;

    protected $fillable = [
        "has_water",
        "has_gas",
        "has_electricity",
        "has_sewer",
        "condition",
        "walls",
        "ceiling",
        "level",
        "level_count",
        "has_heating",
        "has_hot_water",
        "bath",
        "bathroom",
        "area",
        "room_count",
        "has_loggia",
        "has_balcony",
        "has_garage",
        "has_garbage_chute",
        "has_elevator",
        "is_corner",
    ];

    protected $casts = [
        "has_water" => "boolean",
        "has_gas" => "boolean",
        "has_electricity" => "boolean",
        "has_sewer" => "boolean",
        "has_heating" => "boolean",
        "has_hot_water" => "boolean",
        "has_loggia" => "boolean",
        "has_balcony" => "boolean",
        "has_garage" => "boolean",
        "has_garbage_chute" => "boolean",
        "has_elevator" => "boolean",
        "is_corner" => "boolean",
    ];

    public function application(): MorphOne {
        return $this->morphOne(Application::class, "applicable");
    }
}
