<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphOne;

class LandParcel extends Model {
    use HasFactory;

    protected $fillable = [
        "water",
        "gas",
        "electricity",
        "sewer",
        "area",
    ];

    public function application(): MorphOne {
        return $this->morphOne(Application::class, "applicable");
    }
}
