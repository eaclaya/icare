<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Silber\Bouncer\Bouncer;

class ScopeBouncer
{
    /**
     * The Bouncer instance.
     *
     * @var \Silber\Bouncer\Bouncer
     */
    protected $bouncer;

    /**
     * Constructor.
     */
    public function __construct(Bouncer $bouncer)
    {
        $this->bouncer = $bouncer;
    }

    /**
     * Set the proper Bouncer scope for the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (tenancy()->tenant) {
            $user = User::first();
            $churchId = $user->churches()->first()->id;

            $this->bouncer->scope()->to($churchId);
        }


        return $next($request);
    }
}
