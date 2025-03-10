<?php

namespace App\Models;

use Stancl\Tenancy\Contracts\TenantWithDatabase;
use Stancl\Tenancy\Database\Concerns\HasDatabase;
use Stancl\Tenancy\Database\Concerns\HasDomains;
use Stancl\Tenancy\Database\Models\Tenant as BaseTenant;

class Affiliate extends BaseTenant implements TenantWithDatabase
{
    use HasDatabase, HasDomains;

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
}
