<?php

namespace App\Models;

use App\Traits\HasApiActions;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class Team extends Model
{
    use HasApiActions;

    protected $fillable = [
        'name',
        'description',
        'type',
        'group_id',
        'location_id',
        'data',
    ];



    public function eventLinks(): MorphMany
    {
        return $this->morphMany(EventLink::class, 'linkable');
    }

    public function members(): BelongsToMany
    {
        return $this->belongsToMany(Member::class, 'team_member')
            ->withPivot(['role']);
    }

    public function teamType(): BelongsTo
    {
        return $this->belongsTo(TeamType::class);
    }

    public function groups(): BelongsToMany
    {
        return $this->belongsToMany(Group::class);
    }

    public function churches(): BelongsToMany
    {
        return $this->belongsToMany(Church::class);
    }

    public function location(): BelongsTo
    {
        return $this->belongsTo(Location::class);
    }
}
