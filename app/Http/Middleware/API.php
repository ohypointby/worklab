<?php

namespace App\Http\Middleware;

use Closure;

class API
{
    /**
     * Check on cors.
     *
     * @param $request
     * @param Closure $next
     *
     * @return mixed $response
     */
    public function handle($request, Closure $next)
    {
        if($request->getMethod() == 'OPTIONS') {
            header('Access-Control-Allow-Origin: *');
            header('Access-Control-Allow-Methods: POST, GET, OPTIONS, PUT, DELETE');
            header('Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With');
            header('Access-Control-Allow-Credentials: true');
            exit(0);
        }

        $response = $next($request);
        $response->header('Access-Control-Allow-Origin', '*');
        $response->header('Access-Control-Allow-Methods', 'POST, GET, OPTIONS, PUT, DELETE');
        $response->header('Access-Control-Allow-Headers', 'Content-Type, Authorization, X-Requested-With');
        $response->header('Access-Control-Allow-Credentials', 'true');
        return $response;
    }
}

