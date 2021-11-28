<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    //USER REGISTER API - POST
    // URL http://localhost:8000/api/register
    public function register(Request $request)
    {
        $request->validate([
            "name" => "required",
            'email' => 'required|string|email|max:100|unique:users',
            "phone" => "required",
            "password" => "required|confirmed"
        ]);

        //Create user data & save
        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->phone = $request->phone;
        $user->password = bcrypt($request->password);
        $user->save();

        //Response
        return response()->json([
            'status' => "success",
            "message" => "User registered Successfully"
        ], 201);

        //{
        //    "name": "John",
        //    "email": "john@gmail.com",
        //    "phone": "019837747473",
        //    "password": "Hello123",
        //    "password_confirmation": "Hello123"
        //}
    }

    //USER LOGIN API - POST
    //URL http://localhost:8000/api/login
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            "password" => "required"
        ]);

        //Verify user + token
        //The attempt function auto-compare if d email n password is valid for a user in db
        if (!$token = auth()->attempt(["email" => $request->email, "password" => $request->password])) {
            return response()->json([
                'status' => "failed",
                "message" => "Invalid credentials"
            ], 404);
        }
        return response()->json([
            'status' => "success",
            "message" => "Logged in successfully",
            "access_token" => $token
        ], 200);


    }

    //USER PROFILE API - GET
    //URL http://localhost:8000/api/profile
    public function profile()
    {
        $user_data = auth()->user();

        return response()->json([
            "status" => "success",
            "message" => "User profile data",
            "data" => $user_data
        ]);
    }

    //USER LOGOUT API - GET
    //URL http://localhost:8000/api/logout
    public function logout()
    {
        auth()->logout();
        return response()->json([
            "status" => "success",
            "message" => "User logged out",
        ]);
    }
}
