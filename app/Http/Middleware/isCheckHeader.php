<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Response;
class isCheckHeader
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)  
    {  
        $headers = apache_request_headers();
        if(!isset($headers['x-ccloud-auth'])){ 
            return Response::json(['error'=>'No existe header'], 403);  
        }  
  
        if($headers['x-ccloud-auth'] != 'prueba'){  
            return Response::json(['error'=>'Header no coincide'], 403);  
        }
  
        return $next($request);  
    }  
}
