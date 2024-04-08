<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{

    /* Login API */
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(),
            [
                'email'=>'required|string|email',
                'password'=>'required|string|min:6'
            ]
        );

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json([
                'message' => 'Invalid Credentials'
            ],401);
        }

        $token = $user->createToken($user->name.'-AuthToken', ['create', 'update'])->plainTextToken;
        
        return response()->json([
            'access_token' => $token,
        ]);
    }

    /* Register API */
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(),
            [
                'name'=>'required|string|max:255',
                'email'=>'required|string|email|max:255|unique:users',
                'password'=>'required|string|min:6'
            ]
        );

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password)
        ]);

        $token = $user->createToken('authToken', "['create', 'update']")->plainTextToken;

        return response()->json([
            'status' => 'success',
            'message'=>'User Registered Successfully',
            'user'=>$user,
            'authorisation'=> [
                'token' => $token,
                'type' => 'bearer'
            ]
        ]);

    }

    /*User Detail API */
    public function userDetails()
    {

        return response()->json(Auth::user());
    }
}