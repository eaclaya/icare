<?php

namespace App\Models;

use App\Traits\HasApiActions;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Group extends Model
{
    use HasApiActions;

    protected $fillable = ['name', 'group_type_id', 'meta', 'groupable_id', 'groupable_type'];

    protected $casts = [
        'meta' => 'json',
    ];

    public function eventLinks(): MorphMany
    {
        return $this->morphMany(EventLink::class, 'linkable');
    }

    public function members(): BelongsToMany
    {
        return $this->belongsToMany(Member::class)
            ->withPivot(['role']);
    }

    public function teams(): BelongsToMany
    {
        return $this->belongsToMany(Team::class);
    }

    public function groupType(): BelongsTo
    {
        return $this->belongsTo(GroupType::class);
    }

    public function groupable(): MorphTo
    {
        return $this->morphTo();
    }
}
