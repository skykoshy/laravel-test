<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Log;

class UserController extends Controller
{
    public function authenticate(Request $request)
    {
      $credentials = $request->only('email', 'password');
      try {
          if (! $token = JWTAuth::attempt($credentials)) {
              return response()->json(['success' => false]);
          }
      } catch (JWTException $e) {
          return response()->json(['success' => false]);
      }

      $user = User::where('email',$request->post('email'))->first();
      
      return response()->json([
          'token'=>$token,
          'nombre' => $user->name,
          'success'=>true
      ]);
    }


    public function register(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'nombre' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6',
        ]);

        if($validator->fails()){
                return response()->json([
                    "success"=>false,
                    "errors"=>$validator->errors()->toJson()
                ]);
        }

        $user = User::create([
            'name' => $request->post('nombre'),
            'email' => $request->post('email'),
            'password' => Hash::make($request->post('password')),
        ]);

        $token = JWTAuth::fromUser($user);
        $success = true;
        return response()->json(compact('user','token','success'));
    }
}