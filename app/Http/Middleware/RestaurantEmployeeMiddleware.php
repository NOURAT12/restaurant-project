<?php

namespace App\Http\Middleware;

use App\Models\EmployeeRestaurant;
use App\Models\MonthlyPay;
use App\Models\Rusturant;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RestaurantEmployeeMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user=$request->user();
        $employee=EmployeeRestaurant::where('user_id',$user->id)->first();
        $restaurent=Rusturant::where('id',$employee->rustaurant_id)->first();
        if(!$restaurent){
            $response=[
                'message'=> 'Restaurant not created yet ',
            ];
            return response()->json($response, 405);
        }
        if($restaurent->status!=2){
            $response=[
                'message'=> 'you have to complete your Restaurant information ',
            ];
            return response()->json($response, 405);
        }
        $pay=MonthlyPay::where('rustaurant_id', $restaurent->id)->first();
        if(!$pay){
                $response=[
                    'message'=> 'you have to pay for your Restaurant',
                ];
                return response()->json($response, 401);

        }
        if(!$pay->is_paid){
            $response=[
                'message'=> 'you have to pay for your Restaurant',
            ];
            return response()->json($response, 401);
        }
        return $next($request);
    }
}
