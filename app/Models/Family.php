<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class Family extends Model
{
    protected $fillable = ['name', 'type', 'structure', 'data'];

    protected $casts = [
        'data' => 'json',
    ];

    public function eventLinks(): MorphMany
    {
        return $this->morphMany(EventLink::class, 'linkable');
    }

    public function members(): BelongsToMany
    {
        return $this->belongsToMany(Member::class);
    }
}
