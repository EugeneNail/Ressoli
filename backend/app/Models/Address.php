<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

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

    protected $hidden = [
        "created_at",
        "updated_at",
    ];

    public function applications(): HasMany {
        return $this->hasMany(Application::class);
    }
}
