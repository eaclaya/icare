<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Stancl\Tenancy\Contracts\TenantWithDatabase;
use Stancl\Tenancy\Database\Concerns\HasDatabase;
use Stancl\Tenancy\Database\Concerns\HasDomains;
use Stancl\Tenancy\Database\Models\Tenant as BaseTenant;

class Tenant extends BaseTenant
{
    use HasDatabase;

    protected $table = 'tenants';

    public static function getCustomColumns(): array
    {
        return [
            'id',
            'name',
            'description',
            'contact_name',
            'contact_email',
            'contact_phone',
            'street',
            'city',
            'state',
            'zip',
            'country',
            'website',
            'timezone',
        ];
    }

    public function getIncrementing(): bool
    {
        return true;
    }

    public function churches(): BelongsToMany
    {
        return $this->belongsToMany(Church::class);
    }

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class);
    }
}
