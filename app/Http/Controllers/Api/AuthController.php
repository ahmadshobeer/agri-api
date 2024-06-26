<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
class AuthController extends Controller
{
    //

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|max:255|unique:users',
            'password' => 'required|string|min:8'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors());
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password)
        ]);

       event(new Registered($user));

        return response()->json(['message' => 'User registered successfully. Please check your email to verify your account.'], 201);
    

        /* $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'data' => $user,
            'access_token' => $token,
            'token_type' => 'Bearer'
        ]); */
    }

    public function login(Request $request)
    {
        if (! Auth::attempt($request->only('email', 'password'))) {
            return response()->json([
                'success'=>false,
                'message' => 'Invalid Email / password'
            ], 401);
        }
        $user = $request->user();

        if (!$user->hasVerifiedEmail()) {
            return response()->json(['message' => 'Your email address is not verified.'], 403);
        }
     

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'success'=>true,
            'message' => 'Login success',
            'access_token' => $token,
            'token_type' => 'Bearer'
        ]); 
    }

    public function logout()
    {
        Auth::user()->tokens()->delete();
        return response()->json([
            'success'=>true,
            'message' => 'logout success'
        ]);
    }


}
