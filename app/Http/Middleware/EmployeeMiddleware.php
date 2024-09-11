<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EmployeeMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!auth()->user() )
        {
            $response=[
                'message'=>'unAutharaized',
            ];
            return response()->json($response, 401);
        }
        $admin= $request->user();
        if(!$admin->hasRole('employee')){
            $response=[
                'message'=> 'unAutharaized not employee',
            ];
            return response()->json($response, 401);
        }

        return $next($request);
    }
}
