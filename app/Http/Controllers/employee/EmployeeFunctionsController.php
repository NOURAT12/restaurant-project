<?php

namespace App\Http\Controllers\employee;

use App\Models\EmployeeRestaurant;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Reservation;
use App\Models\Rusturant;
use App\Models\Tabel;
use Illuminate\Support\Facades\Validator ;

class EmployeeFunctionsController extends Controller
{
    public function __construct()
    {
        $this->middleware('authEmployee');
        $this->middleware('authRestaurantEmployee');
    }
////////////// display Wait Reservation
public function displayWaitReservation(){
    $user=auth()->user();
    $employee=EmployeeRestaurant::where('user_id',$user->id)->first();
    $restaurant=Rusturant::where('id',$employee->rustaurant_id)->first();
    $reserv=Reservation::where('restaurant_id',$restaurant->id)->where('status',0)->get();
    return response()->json(['message'=>'fetched successfully','data'=>$reserv],200);
}

//////////// display Wait Done Reservation
 public function displayWaitDoneReservation(){
        $user=auth()->user();
        $employee=EmployeeRestaurant::where('user_id',$user->id)->first();
         $restaurant=Rusturant::where('id',$employee->rustaurant_id)->first();
        $reserv=Reservation::where('restaurant_id',$restaurant->id)->where('status',2)->where('done',false)->get();
        return response()->json(['message'=>'fetched successfully','data'=>$reserv],200);

 }

///////////// display All Reservation
 public function displayAllReservation(){
        $user=auth()->user();
        $employee=EmployeeRestaurant::where('user_id',$user->id)->first();
        $restaurant=Rusturant::where('id',$employee->rustaurant_id)->first();
        $reserv=Reservation::where('restaurant_id',$restaurant->id)->get();
        return response()->json(['message'=>'fetched successfully','data'=>$reserv],200);

 }



       ////////// set Done Reservation
   public function setDoneReservation(Request $request){
        $validate=Validator::make($request->all(),
        [
        'reversation_id'=>'required|exists:reservations,id',
        ]);

        if($validate->fails()){
                    return response()->json($validate->errors(),400);
            }

        $reserv=Reservation::find($request->reversation_id);
        $reserv->done=true;
        $table=Tabel::find($reserv->tabel_id);
        $table->state=1;
        $reserv->save();
        $table->save();
        return response()->json(['message'=>'updated successfully','data'=>$reserv],200);

 }



////////////// set State Reservation
public function setStateReservation(Request $request){
        $validate=Validator::make($request->all(),
        [
         'reversation_id'=>'required|exists:reservations,id',
         'status'=>'required',
        ]);

        if($validate->fails()){
                    return response()->json($validate->errors(),400);
         }

         $reserv=Reservation::find($request->reversation_id);
         $reserv->status=$request->status;
         if($request->status==2){
         $table=Tabel::find($reserv->tabel_id);
         $table->state=0;
         $table->save();
         }
         return response()->json(['message'=>'updated successfully','data'=>$reserv],200);

}


////////////// display Wait Order
public function displayWaitOrder(){
    $user=auth()->user();
    $employee=EmployeeRestaurant::where('user_id',$user->id)->first();
    $restaurant=Rusturant::where('id',$employee->rustaurant_id)->first();
    $order=Order::where('rustaurant_id',$restaurant->id)->where('state',0)->get();
    return response()->json(['message'=>'fetched successfully','data'=>$order],200);
}


  //////////// display Accept Order
public function displayAcceptOrder(){
    $user=auth()->user();
    $employee=EmployeeRestaurant::where('user_id',$user->id)->first();
    $restaurant=Rusturant::where('id',$employee->rustaurant_id)->first();
    $order=Order::where('rustaurant_id',$restaurant->id)->where('state',2)->get();
    return response()->json(['message'=>'fetched successfully','data'=>$order],200);
}



   //////////// display Reject Order
public function displayRejectOrder(){
    $user=auth()->user();
    $employee=EmployeeRestaurant::where('user_id',$user->id)->first();
    $restaurant=Rusturant::where('id',$employee->rustaurant_id)->first();
    $order=Order::where('rustaurant_id',$restaurant->id)->where('state',1)->get();
    return response()->json(['message'=>'fetched successfully','data'=>$order],200);
}


//////////// display all Order
public function displayAllOrder(){
    $user=auth()->user();
    $employee=EmployeeRestaurant::where('user_id',$user->id)->first();
    $restaurant=Rusturant::where('id',$employee->rustaurant_id)->first();
    $order=Order::where('rustaurant_id',$restaurant->id)->get();
    return response()->json(['message'=>'fetched successfully','data'=>$order],200);
}


//////////// accept or reject Order
public function acceptOrRejectOrder(Request $request){
    $validate=Validator::make($request->all(),
        [
         'order_id'=>'required|exists:orders,id',
         'status'=>'required',
        ]);

        if($validate->fails()){
                    return response()->json($validate->errors(),400);
         }
    $order=Order::find($request->order_id);
    $order->state=$request->status;
    $order->save();
    return response()->json(['message'=>'updated successfully','data'=>$order],200);
}

//////////// display all tables
public function displayTables(){
    $user=auth()->user();
    $employee=EmployeeRestaurant::where('user_id',$user->id)->first();
    $restaurant=Rusturant::where('id',$employee->rustaurant_id)->first();
    $table=Tabel::where('rustaurant_id',$restaurant->id)->get();
    return response()->json(['message'=>'fetched successfully','data'=>$table],200);
}

//////////// close Or Open Table
public function closeOrOpenTable(Request $request){
    $validate=Validator::make($request->all(),
    [
     'table_id'=>'required|exists:tabels,id',
     'status'=>'required',
    ]);

    if($validate->fails()){
                return response()->json($validate->errors(),400);
     }
    $table=Tabel::find($request->table_id);
    $table->state=$request->status;
    return response()->json(['message'=>'updated successfully','data'=>$table],200);
}
}
