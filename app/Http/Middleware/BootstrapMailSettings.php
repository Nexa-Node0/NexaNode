<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Config;

class BootstrapMailSettings
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        Config::set('mail.default', setting('mail.mailer'));

        Config::set('mail.mailers.smptp', [
            'transport'  => setting('mail.mailer'),
            'host'       => setting('mail.host'),
            'port'       => setting('mail.port'),
            'encryption' => setting('mail.encryption'),
            'username'   => setting('mail.username'),
            'password'   => setting('mail.password'),
            'timeout'    => null
        ]);

        Config::set('mail.form', [
            'address' => setting('mail.from_address'),
            'name'    => setting('mail.from_name')
        ]);

        return $next($request);
    }
}
