<?php

namespace App\Http\Middleware;

use App\Models\Tenant;
use App\Models\Tenant;
use Closure;
use Illuminate\Http\Request;
use Stancl\Tenancy\Resolvers\DomainTenantResolver;
use Stancl\Tenancy\Tenancy;

class InitializeTenantByDomainOrHeader
{
    protected $tenancy;

    protected $tenantResolver;

    public function __construct(
        Tenancy $tenancy,
        DomainTenantResolver $tenantResolver
    ) {
        $this->tenancy = $tenancy;
        $this->tenantResolver = $tenantResolver;
    }

    public function handle(Request $request, Closure $next)
    {
        // Check if the tenant is already initialized
        if ($this->tenancy->initialized) {
            return $next($request);
        }

        $affiliate = null;

        // If tenant is not resolved by domain, try resolving by request header
        if ($request->hasHeader('X-Tenant')) {
            $affiliateId = $request->header('X-Tenant');
            $affiliate = Tenant::where('id', $affiliateId)->first();
        }

        // Fallback to resolve the tenant by domain
        if (! $affiliate) {
            $affiliate = $this->tenantResolver->resolve($request->getHost());
        }

        // Initialize the tenant if found
        if ($affiliate) {
            $this->tenancy->initialize($affiliate);
        }

        return $next($request);
    }
}
