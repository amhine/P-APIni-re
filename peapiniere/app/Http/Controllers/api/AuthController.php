<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Http\Requests\CreateUserRequest;
use App\Http\Requests\login;


class AuthController extends Controller
{
    public function createUser(CreateUserRequest $request)
    {
        
        try {
            $validateUser = $request->validated();

            $user = User::create([
                'name' => $validateUser['name'],
                'email' => $validateUser['email'],
                'password' => Hash::make($validateUser['password']),
                'id_role' => $validateUser['id_role'],
            ]);

            $token = JWTAuth::fromUser($user);

            return response()->json([
                'status' => true,
                'message' => 'User Created Successfully',
                'token' => $token,
            ], 201);

        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => "User not Created ", 
            ], 500);
        }
    }

  
    
    public function loginUser(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (!$token = JWTAuth::attempt($credentials)) {
            return response()->json(['error' => 'Invalid credentials'], 401);
        }

        return response()->json([
            'message' => 'Login successful',
            'token' => $token,
        ]);
    }
    public function logout()
    {
        JWTAuth::parseToken()->invalidate();

        return response()->json(['message' => 'Successfully logged out']);
    }

}
