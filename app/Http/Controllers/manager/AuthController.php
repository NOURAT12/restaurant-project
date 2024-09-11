<?php

namespace App\Http\Controllers\manager;

use App\Http\Controllers\Controller;
use App\Mail\TestMail;
use App\Models\Role;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use PHPOpenSourceSaver\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{

  public function register(Request $request)
  {
      $validate=Validator::make($request->all(),
      [
        'name'=>'required|string',
        'location'=>'required|string',
        'phone'=>'required',
        'password'=>'required|min:8',
        'email'=>'required|unique:users|string|email|max:255',
      ]);

      if($validate->fails()){
        return response()->json($validate->errors(),405);
      }
      $otp = rand(100000,999999);
      $details=['otp'=>$otp,'name'=>$request->name];
      try{Mail::to($request->email)->send(new TestMail($details));}
      catch(Exception $e){

        return response([ "message" => $e->getMessage()],400);

      }
      $user = User::create([
          'name' => $request->name,
          'location' => $request->location,
          'email' => $request->email,
          'phone' => $request->phone,
          'otp' => $otp,
          'password' => Hash::make($request->password),
      ]);
      $role = Role::where('name', 'manager')->first();
      $user->addRole($role);
      return response()->json([
          'message' => 'User created successfully',
          'user' => $user,
          'role' =>$role->name
      ],200);
  }


  public function resendotp (Request $request){
      $validate=Validator::make($request->all(),
      [
      'email'=>'required|string|exists:users|email|max:255',
      ]);

      if($validate->fails()){
       return response()->json($validate->errors(),400);
      }
      $user=User::where('email',$request->email)->first();
      $otp = rand(100000,999999);
      if($user){
          $user->update(['otp'=>$otp]);


          try{Mail::to($request->email)->send(new TestMail($user));}
           catch(Exception $e){

               return response(["message" => $e->getMessage()],400);

           }
           return response([ "message" => "OTP sent successfully"],200);
          }
      }



  public function verifyOtp (Request $request){
      $validate=Validator::make($request->all(),
      [
      'otp'=>'required',
      ]);
      if($validate->fails()){
                  return response()->json($validate->errors(),400);
      }
      $user=User::where('otp',$request->otp)->first();
      if($user){
        if($user->hasVerifiedEmail()){
            return response()->json('Already Verified',200);
          }
        $user->otp=null;
        $user->markEmailAsVerified();
        $user->save();
        $token = JWTAuth::fromUser($user);
        return response(["message" => "verified successfully",'data'=>$user,'token'=>$token],200);
      }

      else{
        return response([ "message" => "unverified"],400);
      }
     }
}
