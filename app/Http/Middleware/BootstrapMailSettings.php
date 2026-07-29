<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Traits\HasMailSettings;

class BootstrapMailSettings
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    use HasMailSettings;

    public function handle(Request $request, Closure $next): Response
    {

        // $this->bootstrapMailConfig();
        return $next($request);
    }
}
