<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class EventLink extends Model
{
    public function event(): BelongsTo
    {
        return $this->belongsTo(Event::class);
    }

    public function linkable(): MorphTo
    {
        return $this->morphTo();
    }
}
