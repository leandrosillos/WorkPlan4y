<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $fields = $request->validate([
            'name' => 'required|max:55',
            'email' => 'email|required|unique:users',
            'password' => 'required|confirmed'
        ]);

        $user = User::create($fields);

        $accessToken = $user->createToken($request->name);

        return response(['user' => $user, 'access_token' => $accessToken->plainTextToken]);
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users',
            'password' => 'required'
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return response(['message' => 'Invalid credentials']);
        }

        $accessToken = $user->createToken($user->name);

        return response(['user' => $user, 'access_token' => $accessToken->plainTextToken]);
    }

    public function logout(Request $request)
    {
        $request->user()->tokens()->delete();

        return response(['message' => 'Successfully logged out']);
    }
}
