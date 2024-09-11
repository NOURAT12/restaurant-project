<?php

namespace App\Http\Controllers\customer;

use App\Http\Controllers\Controller;
use App\Models\Meal;
use App\Models\MonthlyPay;
use App\Models\Offer;
use App\Models\OfferItem;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\OrderOffer;
use App\Models\Reservation;
use App\Models\Rusturant;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;


class CustomerFunctionsController extends Controller
{
    public function __construct()
    {
        $this->middleware('authCustomer');
    }


/////////// Add Reservation
public function addReservation(Request $request){
    $user=auth()->user();
    $validate=Validator::make($request->all(),
    [
       'restaurant_id'=>'required|exists:Rusturants,id',
       'tabel_id'=>'required'
    ]);

   if($validate->fails()){
    return  response()->json($validate->errors(), 400);
   }
   $exist= Reservation::where([
    ['restaurant_id', '=', $request->restaurant_id],
    ['user_id', '=', $user->id],
    ['status','=',0]
    ])->get();
if(count($exist)>0){
    return response()->json(['message'=>'you cant create over one rate in same Restaurant'],405);
}
$rate= Reservation::create([
  'restaurant_id'=>$request->restaurant_id,
  'user_id'=>$user->id,
  'tabel_id'=>$request->tabel_id,
  'status'=>0,
  'done'=>false
]);
return response()->json(['message'=>'added successfully','data'=>$rate],200);

}

//////////Delete Reservation
public function DeleteReservation(Request $request){
    $user=auth()->user();
    $validate=Validator::make($request->all(),
    [
       'reservation_id'=>'required|exists:reservations,id',
    ]);

   if($validate->fails()){
    return  response()->json($validate->errors(), 400);
   }
   $reserv= Reservation::find($request->reservation_id);
   $reserv->delete();
return response()->json(['message'=>'deleted successfully','data'=>$reserv],200);

}

////////////////Update Reservation
public function updateReservation(Request $request){
    $user=auth()->user();
    $validate=Validator::make($request->all(),
    [
       'restaurant_id'=>'required|exists:Rusturants,id',
       'reservation_id'=>'required|exists:reservations,id',
       'tabel_id'=>'required'
    ]);

   if($validate->fails()){
    return  response()->json($validate->errors(), 400);
   }
$reserv= Reservation::find($request->reservation_id);
$reserv->update($request->only('restaurant_id','tabel_id'));
$reserv->save();
return response()->json(['message'=>'updated successfully','data'=>$reserv],200);

}
////////////// display Wait Reservation
public function displayWaitReservation(){
    $user=auth()->user();
    $reserv=Reservation::where('user_id',$user->id)->where('status',0)->get();
    return response()->json(['message'=>'fetched successfully','data'=>$reserv],200);
}

//////////// display Wait Done Reservation
 public function displayWaitDoneReservation(){
        $user=auth()->user();
        $reserv=Reservation::where('user_id',$user->id)->where('status',2)->where('done',false)->get();
        return response()->json(['message'=>'fetched successfully','data'=>$reserv],200);

 }


//////////// display Done Reservation
 public function displayDoneReservation(){
        $user=auth()->user();
        $reserv=Reservation::where('user_id',$user->id)->where('status',2)->where('done',true)->get();
        return response()->json(['message'=>'fetched successfully','data'=>$reserv],200);

 }


///////////// display All Reservation
 public function displayAllReservation(){
        $user=auth()->user();
        $reserv=Reservation::where('user_id',$user->id)->get();
        return response()->json(['message'=>'fetched successfully','data'=>$reserv],200);
 }


///////////// Add Order
 public function addOrder(Request $request){
    $user=auth()->user();
    $validate=Validator::make($request->all(),
    [
      'restaurant_id'=>'required|exists:Rusturants,id',
      'additional_details'=>'required|string',
      'meale_ids.*' => 'exists:meals,id',
      'offer_ids.*' => 'exists:offers,id',
    ]);
    if($validate->fails()){
    return  response()->json($validate->errors(), 400);
    }
    $offer_ids=$request->offer_ids;
    $meale_ids=$request->meale_ids;
    $order= Order::create([
      'user_id'=>$user->id,
      'rustaurant_id'=>$request->restaurant_id,
      'state'=>0,
      'additional_details'=> $request->additional_details,
    ]);

    for ($i=0; $i < count($offer_ids) ; $i++) {
      OrderOffer::create(['order_id' => $order->id,'offer_id'=>$offer_ids[$i]]);
    }
    for ($i=0; $i < count($meale_ids) ; $i++) {
        OrderItem::create(['order_id' => $order->id,'meal_id'=>$meale_ids[$i]]);
      }

  return response()->json(['message'=>'created successfully','data'=>$order],200);
 }


///////////// Update Order
 public function updateOrder(Request $request){
    $user=auth()->user();
    $validate=Validator::make($request->all(),
    [
      'order_id'=>'required|exists:orders,id',
      'restaurant_id'=>'required|exists:Rusturants,id',
      'additional_details'=>'required',

    ]);
    if($validate->fails()){
    return  response()->json($validate->errors(), 400);
    }

    $order= Order::find($request->order_id);
    if($order->state == 0)
    $order->update($request->only('additional_details'));
    $order->save();

  return response()->json(['message'=>'update successfully','data'=>$order],200);
 }


///////////// delete order
 public function DeleteOrder(Request $request){
    $validate=Validator::make($request->all(),
    [
      'order_id'=>'required|exists:orders,id',
    ]);
    if($validate->fails()){
    return  response()->json($validate->errors(), 400);
    }
    $order= Order::find($request->order_id);

    $orderitems=OrderItem::where('order_id',$order->id)->get();
    for ($i=0; $i < count($orderitems) ; $i++) {
    $orderitem= OrderItem::where('id',$orderitems[$i]->id);
    $orderitem->delete();
    }

    $orderoffers=OrderOffer::where('order_id',$order->id)->get();
    for ($j=0; $j < count($orderoffers) ; $j++) {
    $orderoffer= OrderOffer::where('id',$orderoffers[$j]->id);
    $orderoffer->delete();
    }
  $order->delete();
  return response()->json(['message'=>'deleted successfully'],200);
 }



////////////// display Wait Order
public function displayWaitOrder(){
    $user=auth()->user();
    $order=Order::where('user_id',$user->id)->where('state',0)->get();
    return response()->json(['message'=>'fetched successfully','data'=>$order],200);
}


  //////////// display Accept Order
public function displayAcceptOrder(){
    $user=auth()->user();
    $order=Order::where('user_id',$user->id)->where('state',2)->get();
    return response()->json(['message'=>'fetched successfully','data'=>$order],200);
}



   //////////// display Reject Order
public function displayRejectOrder(){
    $user=auth()->user();
    $order=Order::where('user_id',$user->id)->where('state',1)->get();
    return response()->json(['message'=>'fetched successfully','data'=>$order],200);
}


//////////// display all Order
public function displayAllOrder(){
    $user=auth()->user();
    $order=Order::where('user_id',$user->id)->get();
    return response()->json(['message'=>'fetched successfully','data'=>$order],200);
}



}
