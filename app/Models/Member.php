<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Member extends Model
{

    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'phone',
        'dob',
        'gender',
        'location_id',
    ];

    public function user(): HasOne
    {
        return $this->hasOne(User::class, 'member_id', 'id');
    }

    public function organizations(): BelongsToMany
    {
        return $this->belongsToMany(Organization::class)->withPivot(['organization_type']);
    }

    public function teams(): BelongsToMany
    {
        return $this->belongsToMany(Team::class);
    }

    public function groups(): BelongsToMany
    {
        return $this->belongsToMany(Group::class);
    }

    public function location(): BelongsTo
    {
        return $this->belongsTo(Location::class);
    }
}
