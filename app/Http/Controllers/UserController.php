<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return User::all();
    }

    /**
     * Display the specified resource.
     */
    public function show(user $user)
    {
        return $user;
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required',
            'password' => 'required'
        ]);
        
        $user = user::create($request->all());

        return $this->response(201, 'User created successfully', $user);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, user $user)
    {
        $user->update($request->all());

        return $this->response(200, 'User updated successfully', $user);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(user $user)
    {
        $user->delete();
        
    }

    /**
     * Builds a standardized response
     */
    private function response($code, $message, $data)
    {
        return response()->json([
            'code' => $code, 
            'message' => $message, 
            'data' => $data
        ], $code
        );
    }
}
