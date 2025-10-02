<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User; // Don't forget to import the User model if you use the short name

class AuthController extends Controller
{
    
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        // FIX 1: Explicitly use auth('api') for the JWT guard
        if (!$token = auth('api')->attempt($credentials)) { 
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        return $this->respondWithToken($token);
    }

    public function register(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
        ]);

        $user = User::create([ // Use the imported User model
            'name' => $validatedData['name'],
            'email' => $validatedData['email'],
            'password' => bcrypt($validatedData['password']),
        ]);

        // FIX 2: Explicitly use auth('api') for the JWT guard
        $token = auth('api')->login($user); 

        // $this->respondWithToken($token);

        return  response()->json(
            [
                'message' => 'User successfully registered',
                'user' => $user,
                'access_token' => $token,
                'token_type' => 'bearer',
             ], 201);
    }

    public function me()
    {
        // FIX 3: Explicitly use auth('api') for the JWT guard
        return response()->json(auth('api')->user()); 
    }

    public function logout()
    {
        // FIX 4: Explicitly use auth('api') for the JWT guard
        auth('api')->logout();
        return response()->json(['message' => 'Successfully logged out']);
    }

    public function refresh()
    {
        // FIX 5: Explicitly use auth('api') for the JWT guard
        return $this->respondWithToken(auth('api')->refresh());
    }


    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            // FIX 6: Explicitly use auth('api') to access the JWT guard's factory method
            'expires_in' => auth('api')->factory()->getTTL() * 60 
        ]);
    }
}