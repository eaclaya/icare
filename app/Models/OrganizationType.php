<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Model;

class OrganizationType extends Model
{
    public function location(): HasMany
    {
        return $this->hasMany(Organization::class);
    }
}
