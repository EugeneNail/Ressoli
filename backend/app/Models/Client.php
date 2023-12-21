<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Client extends Model {
    use HasFactory;

    protected $fillable = [
        "name",
        "last_name",
        "phone_number"
    ];

    protected $hidden = [
        "created_at",
        "updated_at",
    ];

    public function applications(): HasMany {
        return $this->hasMany(Application::class);
    }
}
