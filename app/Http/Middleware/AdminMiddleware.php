<?php

namespace App\Http\Middleware;

use App\Models\Role;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
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
        if(!$admin->hasRole('admin')){
            $response=[
                'message'=> 'unAutharaized not admin',
            ];
            return response()->json($response, 401);
        }
        return $next($request);
    }
}
