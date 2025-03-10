<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Laravel\Scout\Searchable;

class Church extends Model
{
    use Searchable;

    protected $fillable = [
        "name",
        "nickname",
        "campus_name",
        "street_1",
        "street_2",
        "city",
        "state",
        "zip",
        "country",
        "website",
        "phone",
        "is_campus",
        "data",
    ];

    protected $casts = [
        "data" => "json",
        "is_campus" => "boolean",
    ];

    /**
     * Get the indexable data array for the model.
     *
     * @return array<string, mixed>
     */
    public function toSearchableArray()
    {
        return [
            "id" => (string) $this->id,
            "name" => $this->name,
            "city" => $this->city,
            "state" => $this->state,
            "zip" => $this->zip,
            "families_count" => (int) $this->families()->count(),
            "members_count" => (int) $this->members()->count(),
            "location" => [(float) $this->lat, (float) $this->lng],
            "created_at" => $this->created_at->timestamp,
        ];
    }

    public function eventLinks(): MorphMany
    {
        return $this->morphMany(EventLink::class, "linkable");
    }

    public function members(): BelongsToMany
    {
        return $this->belongsToMany(Member::class)->withPivot(["church_type"]);
    }

    public function families(): BelongsToMany
    {
        return $this->belongsToMany(Family::class);
    }
}
