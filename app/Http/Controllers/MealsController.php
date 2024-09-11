<?php

namespace App\Http\Controllers;

use App\Models\Meal;
use Illuminate\Http\Request;
use App\Models\RusRate;
use App\Models\Rusturant;
use App\Models\User;
use App\Traits\mealsTrait;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\File as FacadesFile;
class MealsController extends Controller
{
    use mealsTrait;
    //
    public function signup (Request $request){
        $validate=Validator::make($request->all(),
        [
           'name'=>'required|string',
           'email'=>'required|string',
           'password'=>'required|string',
           'location'=>'required|string',
          
        ]);
    
       if($validate->fails()){
        return  response()->json($validate->errors(), 400);
       }
       $user=User::create($request->all());
       event(new Registered($user));
       auth()->login($user);
       return response()->json($user,200);
    }

    public function store_meal (Request $request){

        $validate=Validator::make($request->all(),
        [
           'name'=>'required|string',
           'description'=>'required|string',
           'image'=>'mimes:jpg,jpeg,png|required',
           'category_id'=>'required|exists:categories,id',
           'rustaurant_id'=>'required|exists:rusturants,id',
           'price'=>'required',
           'menu'=>'required',
        ]);
    
       if($validate->fails()){
        return  response()->json($validate->errors(), 400);
       }
        $file_name = $this->saveImage($request -> image ,'images/meals');

        $meal= Meal::create([
        'name' => $request->name,
        'description' => $request->description,
        'image' => $file_name,
        'category_id' => $request->category_id,
        'rustaurant_id' => $request->rustaurant_id,
        'price' => $request->price,
        'menu' => $request->menu,
        ]);
        return  response()->json($meal, 200);

    }

    public function delete_meal (Request $request){

        $validate=Validator::make($request->all(),
        [
           'meal_id'=>'required|exists:meals,id',
        ]);
    
       if($validate->fails()){
        return  response()->json($validate->errors(), 400);
       }
      
      $meal= Meal::find($request->meal_id);
      if($meal->image)
       {
        FacadesFile::delete(public_path("images/$meal->image"));
       }
        $meal->delete();
        return  response()->json("deleted sucsess", 200);

    }

    public function update_meal (Request $request){

        $validate=Validator::make($request->all(),
        [
           'meal_id'=>'required|exists:meals,id',
           'name'=>'required|string',
           'description'=>'required|string',
           'image'=>'mimes:jpg,jpeg,png|required',
           'price'=>'required',
        ]);
    
       if($validate->fails()){
        return  response()->json($validate->errors(), 400);
       }
    
      $meal= Meal::find($request->meal_id);
       if($meal->image)
       {
        FacadesFile::delete(public_path("images/$meal->image"));
       }
       $file_name = $this->saveImage($request -> image ,'images/meals');
       $meal->update([ 'image' => $file_name]);
        $meal->update($request->except("meal_id","image"));
        return  response()->json($meal, 200);

    }
    public function create_restaurent (Request $request){

        $validate=Validator::make($request->all(),
        [
           'phone'=>'required|numeric',
           'name'=>'required|string',
           'description'=>'required|string',
           'image'=>'mimes:jpg,jpeg,png|required',
           'table_number'=>'required',
           'location'=>'required',
        ]);
    
       if($validate->fails()){
        return  response()->json($validate->errors(), 400);
       }
    
       $file_name = $this->saveImage($request -> image ,'images/meals');
      $restaurant= Rusturant::create([
        'name' => $request->name,
        'description' => $request->description,
        'image' => $file_name,
        'phone' => $request->phone,
        'table_number' => $request->table_number,
        'location' => $request->location,
        ]);
     
    
        return  response()->json($restaurant, 200);

    }

    public function update_restaurent (Request $request){

        $validate=Validator::make($request->all(),
        [
           'phone'=>'required|numeric',
           'name'=>'required|string',
           'description'=>'required|string',
           'image'=>'mimes:jpg,jpeg,png|required',
           'rustaurant_id'=>'required|exists:rusturants,id',
           'table_number'=>'required',
           'location'=>'required',
        ]);
    
       if($validate->fails()){
        return  response()->json($validate->errors(), 400);
       }
    
      $restaurant= Rusturant::find($request->rustaurant_id);
       if($restaurant->image)
       {
        FacadesFile::delete(public_path("images/$restaurant->image"));
       }
       $file_name = $this->saveImage($request -> image ,'images/meals');
       $restaurant->update([ 'image' => $file_name]);
        $restaurant->update($request->except("meal_id","image"));
        return  response()->json($restaurant, 200);

    }

    public function show_restaurent (Request $request){

        $validate=Validator::make($request->all(),
        [
           'rustaurant_id'=>'required|exists:rusturants,id',
        ]);
    
       if($validate->fails()){
        return  response()->json($validate->errors(), 400);
       }
      $restaurant= Rusturant::where('id',1)->first();
     
        return  response()->json($restaurant, 200);

    }
}
