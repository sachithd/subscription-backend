<?php

namespace App\Http\Middleware;

use App\Traits\RestApiResponseTrait;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureIpAddressIsValid
{
    use RestApiResponseTrait;
    //TODO Move the IP addresses to a config file or a database
    protected array $blockedIpArray = [
        '172.26.0.2',
        '172.26.0.3',
    ];
    /**
     * Handle an incoming request.
     * Checks the user ip is in blacklisted ip list
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $ip = $request->ip(); //172.26.0.1 for testing
        if (in_array($ip, $this->blockedIpArray)) {
            return $this->error("This ip address has been blocked");
        }
        return $next($request);
    }
}
