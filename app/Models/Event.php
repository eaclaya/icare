<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Event extends Model
{
    protected $fillable = [
        "name",
        "user_id",
        "type",
        "description",
        "location",
        "contact_name",
        "contact_phone",
        "timezone",
        "max_size",
        "location_id",
        "data",
    ];

    protected $casts = [
        "data" => "json",
    ];

    public function links(): HasMany
    {
        return $this->hasMany(EventLink::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
