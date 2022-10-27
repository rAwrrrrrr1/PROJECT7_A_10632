<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Validator;
use Illuminate\Support\Facades\Session;

class AuthController extends Controller
{
    public function register(Request $request){
        $registrationData = $request->all();

        $validate Validator::make($registrationData,[
            'name' => 'required|max:60',
            'email' => 'required|email:rfc,dns|unique:users',
            'passqord' => 'required'
        ]);

        if($validate->fails())
            return response(['message' => $validate->error()],404);

        $registrationData['password'] = bcrypt($request->password);

        $user = User::create($registrationData);

        return response([
            'message' => 'Register Succes',
            'user' => $user
        ], 200);

        public function login(Request $request){
            $loginData = $request->all();

            $validate = Validator::make($loginData,[
                'email' => 'required|email:rfc, dns',
                'password' => 'required'
            ]);

            if($validate->fails())
                return response(['message' => $validate->error()],404);

            if(!Auth::attempt($loginData))
                return respons(['message' => 'Invalid Crendential'], 401);

            $user = Auth::user();
            $token = $user->createToken('Authentication Token')-> AccessToken;

            return response([
                'message' => 'Authenticated',
                'user' => $user,
                'token_type' => 'Bearer',
                'access_token' => $token,
            ]);
        }

    }
}