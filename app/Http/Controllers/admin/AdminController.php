<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Mail\AcceptMail;
use App\Models\BlockedUser;
use App\Models\MonthlyPay;
use App\Models\Role;
use App\Models\Rusturant;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class AdminController extends Controller
{
    public function __construct()
    {
          $this->middleware('authAdmin')->except('login','getImage');
    }


////////// display RestaurantWait
    public function displayRestaurantWait()
    {
        $restaurant = Rusturant::where('status', 0)->get();
        return response(["message" => "fetched successfully", 'data' => $restaurant], 200);
    }

/////////// accept Restaurant
    public function acceptRestaurant(Request $request)
    {
        $validate=Validator::make($request->all(),
        [
           'cost'=>'required',
           'rustaurant_id'=>'required|exists:rusturants,id',
        ]);
       if($validate->fails()){
        return  response()->json($validate->errors(), 400);
       }
        $restaurant = Rusturant::find($request->rustaurant_id);
       $pay= MonthlyPay::create([
            'cost'=> $request->cost,
            'rustaurant_id'=> $request->rustaurant_id,
            'is_paid'=> true,
            'start'=> now(),
            'end'=> now()->addMonth(),
        ]);
        $restaurant->status=2;
        $restaurant->save();
        $email=User::find($restaurant->manager_id)->email;
        try{Mail::to($email)->send(new AcceptMail());}
        catch(Exception $e){
            return response([ "message" => $e->getMessage()],400);
        }
        return response(["message" => "accepted successfully", 'data' => [$restaurant,$pay]], 200);
    }

/////////// reject Restaurant
    public function rejectRestaurant(Request $request)
    {
       
        $validate=Validator::make($request->all(),
        [
           'rustaurant_id'=>'required|exists:rusturants,id',
        ]);
       if($validate->fails()){
         return  response()->json($validate->errors(), 400);
        }
        $restaurant = Rusturant::find($request->rustaurant_id);
        $restaurant->status=1;
        $restaurant->save();
        return response(["message" => "rejected successfully", 'data' => $restaurant], 200);
    }

/////////// display all Restaurant
    public function displayAllRestaurant()
    {
        $restaurant = Rusturant::orderBy('status')->get();
        return response(["message" => "fetched successfully", 'data' => $restaurant], 200);
    }    

    /////////// display users
    public function displayUsers()
    { 
        $role=Role::where('name','user')->first();
        $users=$role->users;
        return response(["message" => "fetched successfully", 'data' => $users], 200);
    }    

    /////////// display employees
    public function displayEmployees()
    {
        $role=Role::where('name','employee')->first();
        $users=$role->users;
        return response(["message" => "fetched successfully", 'data' => $users], 200);

    }    

    /////////// display managers
    public function displayManagers()
    {
        $role=Role::where('name','manager')->first();
        $users=$role->users;
        return response(["message" => "fetched successfully", 'data' => $users], 200);
    }  
     
 
     /////////// block User
 public function blockUser(Request $request)
 {
    $validate=Validator::make($request->all(),
        [
           'user_id'=>'required|exists:users,id',
        ]);
       if($validate->fails()){
         return  response()->json($validate->errors(), 400);
        }
     $user=User::find($request->user_id);
     $block=BlockedUser::where('user_id',$request->user_id)->first();
     if($block){return response(["message" => "user alredy blocked"], 200);
     }
     BlockedUser::create(['user_id'=>$user->id]);
     return response(["message" => "blocked successfully", 'data' => $user], 200);
 } 


 /////////// unblock User
 public function unblockUser(Request $request)
 {
    $validate=Validator::make($request->all(),
        [
           'user_id'=>'required|exists:users,id',
        ]);
       if($validate->fails()){
         return  response()->json($validate->errors(), 400);
        }
        $user=User::find($request->user_id);
     $block= BlockedUser::where('user_id',$request->user_id)->first();
     $block->delete();
     return response(["message" => "unblocked successfully", 'data' => $user], 200);
 } 
 
 
  /////////// display blocked Users
  public function displayblockedUsers()
  {
      $block= BlockedUser::get();
      return response(["message" => "fetched successfully", 'data' => $block], 200);
  }  

    /////////// set Pay Restaurant 
    public function setPayRestaurant(Request $request)
    {
        $validate=Validator::make($request->all(),
        [
           'rustaurant_id'=>'required|exists:rusturants,id',
        ]);
       if($validate->fails()){
         return  response()->json($validate->errors(), 400);
        }

         $pay= MonthlyPay::where(
            'rustaurant_id', $request->rustaurant_id,
        )->first();
        $pay->is_paid=true;
        $pay->start=now();
        $pay->end=now()->addMonth();
        $pay->save();
        return response(["message" => "updated successfully", 'data' => $pay], 200);
    }  
}
