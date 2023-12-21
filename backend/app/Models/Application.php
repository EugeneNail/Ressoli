<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Application extends Model {
    use HasFactory;

    protected $fillable = [
        "price",
        "contract",
        "has_mortgage",
    ];

    protected $casts = [
        "is_active" => "boolean",
        "has_mortgage" => "boolean",
    ];

    public function user(): BelongsTo {
        return $this->belongsTo(User::class);
    }

    public function client(): BelongsTo {
        return $this->belongsTo(Client::class);
    }

    public function address(): BelongsTo {
        return $this->belongsTo(Address::class);
    }

    public function applicable(): MorphTo {
        return $this->morphTo();
    }
}
