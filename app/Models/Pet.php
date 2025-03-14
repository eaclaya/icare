<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class Pet extends Model
{
    protected $fillable = ['name', 'location_id',  'pet_type', 'dob', 'primary_contact_id'];

    public function groups(): MorphMany
    {
        return $this->morphMany(Group::class, 'groupable');
    }

    public function location(): BelongsTo
    {
        return $this->belongsTo(Location::class);
    }
}
