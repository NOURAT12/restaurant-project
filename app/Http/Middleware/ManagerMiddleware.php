<?php

namespace App\Http\Middleware;

use App\Models\MonthlyPay;
use App\Models\Rusturant;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ManagerMiddleware
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
        if(!$admin->hasRole('manager')){
            $response=[
                'message'=> 'unAutharaized not manager',
            ];
            return response()->json($response, 401);
        }
        if(!$admin->hasVerifiedEmail()){
            $response=[
                'message'=> 'not verified manager',
            ];
            return response()->json($response, 401);
        }
        return $next($request);
    }
}
