<?php

namespace App\Models;

use App\Traits\HasApiActions;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Laravel\Scout\Searchable;

class Organization extends Model
{
    use HasApiActions, Searchable;

    protected $fillable = [
        'name',
        'nick',
        'campus',
        'website',
        'phone',
        'data',
    ];

    protected $casts = [
        'data' => 'json',
    ];

    // protected function getApiActions()
    // {

    //     return [
    //         'show',
    //         'edit',
    //         'invite' => [
    //             'label' => __('Invite'),
    //             'url' => route('churches.invite', $this->id),
    //         ],
    //         'delete'
    //     ];
    // }

    /**
     * Get the indexable data array for the model.
     *
     * @return array<string, mixed>
     */
    public function toSearchableArray()
    {
        return [
            'id' => (string) $this->id,
            'name' => $this->name,
            'city' => $this->city,
            'state' => $this->state,
            'zip' => $this->zip,
            'groups_count' => (int) $this->groups()->count(),
            'members_count' => (int) $this->members()->count(),
            'location' => [(float) $this->lat, (float) $this->lng],
            'created_at' => $this->created_at->timestamp,
        ];
    }

    public function location(): BelongsTo
    {
        return $this->belongsTo(Location::class);
    }

    public function type(): BelongsTo
    {
        return $this->belongsTo(OrganizationType::class);
    }

    public function eventLinks(): MorphMany
    {
        return $this->morphMany(EventLink::class, 'linkable');
    }

    public function members(): BelongsToMany
    {
        return $this->belongsToMany(Member::class, 'organization_member')->withPivot(['organization_type']);
    }

    public function teams(): BelongsToMany
    {
        return $this->belongsToMany(Team::class);
    }
}
