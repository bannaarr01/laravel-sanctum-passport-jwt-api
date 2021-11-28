<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Author;
use http\Env\Response;
use Illuminate\Http\Request;

class AuthorController extends Controller
{
    //REGISTER API - POST
    //URL http://localhost:8000/api/register
    public function register(Request $request)
    {
        $request->validate([
            "name" => "required",
            "email" => "required|email|unique:authors",
            "password" => "required|confirmed",
            "phone" => "required"
        ]);

       // $author =
        Author::create([
            "name" => $request->name,
            "email" => $request->email,
            "phone" => $request->phone,
            "password" => bcrypt($request->password)
        ]);
       // $author->save();

        return response()->json([
            "status" => "success",
            "message" => "Author created successfully"
        ],201);

    }

    //POST API - POST
    //URL http://localhost:8000/api/login
    public function login(Request $request)
    {
        $login_data = $request->validate([
            "email" => "required",
            "password" => "required"
        ]);

        //Validate author data
        if(!auth()->attempt($login_data)){
            return response()->json([
                "status" => "failed",
                "message" => "Invalid credentials"
            ]);
        }
        //Token
        // $token = auth()->user()->createToken("auth_token");
        $token = auth()->user()->createToken("auth_token")->accessToken;

        return response()->json([
            "status" => "success",
            "message" => "Author logged in successfully",
            "access_token" => $token
        ],200);

    }

    //PROFILE API - GET
    //URL http://localhost:8000/api/profile
    public function profile()
    {
        $user_data = auth()->user();

        return response()->json([
            "status" => "success",
            "message" => "User Data",
            "data" => $user_data
        ],200);
    }

    //LOGOUT API - POST
    //URL http://localhost:8000/api/logout
    public function logout(Request $request)
    {
        //get token value
        $token = $request->user()->token(); //get d passport token value

        //revoke token
        $token->revoke();

        return response()->json([
            "status" => "success",
            "message" => "Author logged out successfully"
        ]);

    }


}
