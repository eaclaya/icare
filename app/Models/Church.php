<?php

namespace App\Models;

use App\Traits\HasApiActions;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Laravel\Scout\Searchable;

class Church extends Model
{
    use HasApiActions, Searchable;

    protected $fillable = [
        'name',
        'nickname',
        'campus_name',
        'street_1',
        'street_2',
        'city',
        'state',
        'zip',
        'country',
        'website',
        'phone',
        'is_campus',
        'data',
    ];

    protected $casts = [
        'data' => 'json',
        'is_campus' => 'boolean',
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

    public function eventLinks(): MorphMany
    {
        return $this->morphMany(EventLink::class, 'linkable');
    }

    public function members(): BelongsToMany
    {
        return $this->belongsToMany(Member::class)->withPivot(['church_type']);
    }

    public function teams(): BelongsToMany
    {
        return $this->belongsToMany(Team::class);
    }
}
