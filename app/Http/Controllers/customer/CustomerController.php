<?php

namespace App\Http\Controllers\customer;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\CategoryRestaurant;
use App\Models\Meal;
use App\Models\MealRate;
use App\Models\Offer;
use App\Models\RusRate;
use App\Models\Rusturant;
use App\Models\Tabel;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;


class CustomerController extends Controller
{
    public function __construct()
    {
      $this->middleware('authCustomer')->except('login');
    }

     //////////// login
    public function login(Request $request){
        $validate=Validator::make($request->all(),
        [
          'password'=>'required|min:8',
          'email'=>'required|exists:users|string|email|max:255',
        ]);

        if($validate->fails()){
            return response()->json($validate->errors(),400);
        }
        if (!auth()->validate($request->only('email','password')) )
        {
          return response()->json(['Customer'=>'failed password'],400);
        }
        $user = User::where('email' , $request->email)->first();
        $role='';
        if($user->hasRole('employee')){
          $role='employee';
        }
        if($user->hasRole('manager')){
          $role='manager';
        }
        if($user->hasRole('admin')){
          $role='admin';
        }
        if($user->hasRole('user')){
          $role='user';
        }
        $token = auth()->login($user);
        return response()->json([
            'message' => 'login successfully',
            'data' => $user,
            'Role' => $role,
            'token'=>$token
        ],200);
    }


    ///////////////logout
    public function logout()
    {
        auth()->logout();
        return response()->json(['message' => 'logout successfully'], 200);
    }


///////////////display All Restaurant
    public function displayAllRestaurant()
    {
        $restaurant = Rusturant::Where('status',2)->get();
        return response(["message" => "fetched successfully", 'data' => $restaurant], 200);
    }


////////////display Table

public function displayTable(Request $request)
{
    $validate=Validator::make($request->all(),
    [
      'rusturant_id'=>'required|exists:Rusturants,id',
    ]);
    $restaurant = Tabel::where([
        ['rustaurant_id', '=', $request->rusturant_id],
    ])->get();
    return response(["message" => "fetched successfully", 'data' => $restaurant], 200);
}


//////////display Restaurant Information
    public function displayRestaurantInformation(Request $request)
    {
        $validate=Validator::make($request->all(),
        [
          'rusturant_id'=>'required|exists:Rusturants,id',
        ]);
        $restaurant = Rusturant::where([
            ['id', '=', $request->rusturant_id],
            ['status', '=', 2]
        ])->get();
        return response(["message" => "fetched successfully", 'data' => $restaurant], 200);
    }


////////////display Restaurant Details
    public function displayRestaurantDetails(Request $request)
    {
        $validate=Validator::make($request->all(),
        [
          'rusturant_id'=>'required|exists:Rusturants,id',
        ]);
        if($validate->fails()){
        return  response()->json($validate->errors(), 400);
        }
        $restaurant = Rusturant::where([
            ['id', '=', $request->rusturant_id],
            ['status', '=', 2]
        ])->first();
        return response(["message" => "fetched successfully", 'data' =>  $restaurant->description], 200);
    }


///////////search
    public function search(Request $request)
    {
        $validate=Validator::make($request->all(),
        [
          'name'=>'required',
        ]);
        if($validate->fails()){
        return  response()->json($validate->errors(), 400);
        }
        $restaurant = Rusturant::Where('name','like','%'.$request->name.'%')->get();
        return response(["message" => "fetched successfully", 'data' => $restaurant], 200);
    }


    ///////// display offers
public function displayOffers (){
    $offer= Offer::where('state',true)->latest()->get();
    return response()->json(['message'=>'fetched successfully','data'=>$offer],200);
  }


/////////////display Restaurant Offers
    public function displayRestaurantOffers (Request $request){
        $validate=Validator::make($request->all(),
        [
          'restaurant_id'=>'required|exists:Rusturants,id',
        ]);
        $restaurant=Rusturant::where('id',$request->restaurant_id)->first();
        $offer= Offer::latest()->where('rustaurant_id',$restaurant->id)->get();
        return response()->json(['message'=>'fetched successfully','data'=>$offer],200);
    }

////////Add Restaurant Rate
    public function addRestaurantRate (Request $request){
        $user=$request->user();
        $validate=Validator::make($request->all(),
        [
          'rusturant_id'=>'required|exists:Rusturants,id',
          'percent' => 'required',
        ]);
        if($validate->fails()){
        return  response()->json($validate->errors(), 400);
        }
        $exist= RusRate::where([
            ['rusturant_id', '=', $request->rusturant_id],
            ['user_id', '=', $user->id]
            ])->get();
        if(count($exist)>0){
            return response()->json(['message'=>'you cant create over one rate in same Restaurant'],405);
        }
        $rate= RusRate::create([
          'rusturant_id'=>$request->rusturant_id,
          'user_id'=>$user->id,
          'percent'=>$request->percent,
        ]);
      return response()->json(['message'=>'added successfully','data'=>$rate],200);
    }

///////////////Update Restaurant Rate
    public function updateRestaurantRate (Request $request){
        $validate=Validator::make($request->all(),
        [
          'rate_id'=>'required|exists:rus_rates,id',
          'percent' => 'required',
        ]);
        if($validate->fails()){
        return  response()->json($validate->errors(), 400);
        }
        $rate= RusRate::where('id', '=', $request->rate_id)->first();
        $rate->update($request->only('percent'));
        $rate->save();
        return response()->json(['message'=>'updated successfully','data'=>$rate],200);

    }

/////////////Delete Restaurant Rate
    public function deleteRestaurantRate (Request $request){
        $validate=Validator::make($request->all(),
        [
          'rate_id'=>'required|exists:rus_rates,id',
        ]);
        if($validate->fails()){
        return  response()->json($validate->errors(), 400);
        }
        $del=RusRate::where('id', '=', $request->rate_id)->first();
        $del->delete();
        return response()->json(['message'=>'deleted successfully','data'=>$del],200);

    }


////////Add Meal Rate
    public function addMealRate (Request $request){
        $user=$request->user();
        $validate=Validator::make($request->all(),
        [
          'meal_id'=>'required|exists:meals,id',
          'percent' => 'required',
        ]);
        if($validate->fails()){
        return  response()->json($validate->errors(), 400);
        }
        $exist= MealRate::where([
            ['meal_id', '=', $request->meal_id],
            ['user_id', '=', $user->id]
            ])->get();
        if(count($exist)>0){
            return response()->json(['message'=>'you cant create over one rate in same Meal'],405);
        }
        $rate= MealRate::create([
          'meal_id'=>$request->meal_id,
          'user_id'=>$user->id,
          'percent'=>$request->percent,
        ]);
      return response()->json(['message'=>'added successfully','data'=>$rate],200);

    }
////////update Meal Rate
    public function updateMealRate (Request $request){
        $validate=Validator::make($request->all(),
        [
          'rate_id'=>'required|exists:meal_rates,id',
          'percent' => 'required',
        ]);
        if($validate->fails()){
        return  response()->json($validate->errors(), 400);
        }
        $rate= MealRate::where('id',$request->rate_id)->first();
            $rate->update($request->only('percent'));
            $rate->save();
        return response()->json(['message'=>'added successfully','data'=>$rate],200);

    }
////////delete Meal Rate
    public function deleteMealRate (Request $request){
        $validate=Validator::make($request->all(),
        [
            'rate_id'=>'required|exists:meal_rates,id',
        ]);
        if($validate->fails()){
        return  response()->json($validate->errors(), 400);
        }
        $del=MealRate::where('id',$request->rate_id)->first();
        $del->delete();
      return response()->json(['message'=>'added successfully','data'=>$del],200);
    }


///////// display menu
public function displayMenu (Request $request){
    $validate=Validator::make($request->all(),
    [
      'rusturant_id'=>'required|exists:Rusturants,id',
    ]);
    if($validate->fails()){
    return  response()->json($validate->errors(), 400);
    }
    $meals= Meal::where('menu',true)->where('rustaurant_id',$request->rusturant_id)->orderBY('category_id','desc')->get();
    return response()->json(['message'=>'fetched successfully','data'=>$meals],200);
  }


////////////////  display Restaurant Categorys
public function displayCategoryRestaurant(Request $request){
    $validate=Validator::make($request->all(),
    [
      'restaurant_id'=>'required|exists:Rusturants,id',
    ]);
    if($validate->fails()){
    return  response()->json($validate->errors(), 400);
    }
        $group=CategoryRestaurant::where('restaurant_id',$request->restaurant_id)->get();
        if($group){
         $ids = [];
         foreach ($group as $item) {
             $ids[] = $item->category_id;
         }
         $category= Category::whereIn('id',$ids)->get();

         return response()->json(['message'=>'fetched successfully','data'=>$category],200);
         }
         return response()->json(['message'=>'no categories yet'],200);
  }

////////  display Category Mael

public function displayCategoryMeal(Request $request){
    $validate=Validator::make($request->all(),
    [
      'rustaurant_id'=>'required|exists:Rusturants,id',
      'category_id'=>'required|exists:categories,id',
    ]);
    if($validate->fails()){
    return  response()->json($validate->errors(), 400);
    }
        $meals= Meal::where([
            ['rustaurant_id',$request->rustaurant_id],
            ['category_id',$request->category_id]
            ])->get();
         return response()->json(['message'=>'fetched successfully','data'=>$meals],200);
  }

}
