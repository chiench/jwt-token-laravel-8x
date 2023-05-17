<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $data = $request->all();
        // DB::table('users')->truncate();
        // Validate Manually
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|confirmed|min:4',
        ]);
        // If the existed errors
        if ($validator->fails()) {
            return response()->json([
                'error' => $validator->errors()
            ], 422);
        }
        // The data input is passed
        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);
        // create token
        $token = JWTAuth::fromUser($user);
        return response()->json([
            'data' => $user,
            'token' => $token,
        ], 201);
    }
    public function login(LoginRequest $request)
    {
        dd($request->all());

    }
}
