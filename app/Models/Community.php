<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class Community extends Model
{
    protected $fillable = [
        'name',
        'description',
        'type',
        'family_id',
        'location_id',
        'data',
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
