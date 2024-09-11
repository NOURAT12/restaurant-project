<?php

namespace App\Http\Controllers;

use Illuminate\Auth\Events\Verified;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;

class VerifyController extends Controller
{
   public function sendVerificationEmail(Request $request){
      if($request->user()->hasVerifiedEmail()){
        return response()->json('Already Verified',200);
      }
      $request->user()->sendEmailVerificationNotification();
      return response()->json('Verification Link Sent..',200);
   }
   
   public function verify(EmailVerificationRequest $request){
    if($request->user()->hasVerifiedEmail()){
        return response()->json('Already Verified',200);
      }
      if($request->user()->markEmailAsVerified()){
        event(new Verified($request->user()));
      }
      return response()->json('email has been verified',200);
   }
}
