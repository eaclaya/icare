<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class Chat extends Model
{
    protected $fillable = ["name", "is_group"];

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class);
    }

    public function messages(): MorphMany
    {
        return $this->morphMany(Message::class,"messageable");
    }

}
