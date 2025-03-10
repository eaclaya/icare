<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Silber\Bouncer\Database\HasRolesAndAbilities;

class Member extends Model
{

    use HasRolesAndAbilities;

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

    public function churches(): BelongsToMany
    {
        return $this->belongsToMany(Church::class)->withPivot(['church_type']);
    }

    public function communities(): BelongsToMany
    {
        return $this->belongsToMany(Community::class);
    }

    public function families(): BelongsToMany
    {
        return $this->belongsToMany(Family::class);
    }

    public function location(): BelongsTo
    {
        return $this->belongsTo(Location::class);
    }
}
