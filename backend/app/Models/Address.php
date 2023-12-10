<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Address extends Model {
    use HasFactory;

    protected $fillable = [
        "number",
        "unit",
        "type_of_street",
        "street",
        "city",
        "postal_code",
        "longitude",
        "latitude"
    ];
}
