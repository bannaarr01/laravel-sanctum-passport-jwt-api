<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class StudentController extends Controller
{
    //REGISTER API - POST
    //URL http://localhost:8000/api/register
    public function register(Request $request)
    {
        //Validate
        $request->validate([
            "name" => "required",
            "email" => "required|email|unique:students",
            "password" => "required|confirmed",
        ]); //with d password confirmed we can use 2 form field
        //    "name" : "John",
        //    "email" : "john@gmail.com",
        //    "password" : "Hello123",
        //    "password_confirmation" : "Hello123"

        //Create data
        $student = new Student();
        $student->name = $request->name;
        $student->email = $request->email;
        $student->password = Hash::make($request->password);
        $student->phone = isset($request->phone) ? $request->phone : ""; //can be empty and ifnot insert
        $student->save();

        //Send response
        return response()->json([
            "message" => "Student registered successfully"
        ], 201); //201 CREATED, //200 OK
    }
    //400 Bad Request, 401 Unauthorized, 403 Forbidden, 404 Not Found, 498 Invalid Token, 419 Page Expired

    //LOGIN API - POST
    //URL http://localhost:8000/api/login
    public function login(Request $request)
    {
        //Validation
        $request->validate([
            "email" => "required|email",
            "password" => "required"
        ]);
        //Check Student
        $student = Student::where("email", "=", $request->email)->first();
        if (isset($student->id)) {
            //Comparing the input password with d one in db for ds user
            if (Hash::check($request->password, $student->password)) {
                //Create Token
                $token = $student->createToken("auth_token")->plainTextToken;
                //Send Response
                return response()->json([
                    "message" => "Student logged in successfully",
                    "access_token" => $token
                ], 202);

            } else {
                return response()->json([
                    "message" => "Password didn't match"
                ], 404);
            }//end of compare password

        } else { //Send Response
            return response()->json([
                "message" => "Student not found"
            ], 404);
        }


    }

    //BELOW 2 METHOD NEED AUTHENTICATION
    //PROFILE API - GET
    //URL http://localhost:8000/api/profile
    //USE GENERATED TOKEN WHEN LOGIN AS BEARER IN HEADER TO GET PROFILE
    public function profile()
    {
        return response()->json([
            "message" => "Student Profile Information",
            "data" => auth()->user()
        ], 200);
    }

    //LOGOUT API - GET
    //URL http://localhost:8000/api/logout
    //DELETE THE GENERATED TOKEN WHEN LOGIN 2 MAKE IT INVALID WEN LOGOUT
    public function logout()
    {
        auth()->user()->tokens()->delete();
        return response()->json([
            "message" => "Student logout successfully",
        ], 200);
    }

}
