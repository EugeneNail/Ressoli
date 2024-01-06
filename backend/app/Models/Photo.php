<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Photo extends Model {
    use HasFactory;

    protected $fillable = [
        "path",
    ];

    protected $hidden = [
        "created_at",
        "updated_at"
    ];

    public function application(): BelongsTo {
        return $this->belongsTo(Application::class);
    }
}
