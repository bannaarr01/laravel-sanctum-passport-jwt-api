<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Employee;
use Illuminate\Http\Request;

class ApiController extends Controller
{
    //CREATE API - POST
    //URL - http://localhost:8000/api/add-employee
    public function CreateEmployee(Request $request)
    {
        $request->validate([
            "name" => "required",
            "email" => "required|email|unique:employees",
            "phone" => "required|max:11",
            "age" => "required",
        ]);
        $employee = new Employee();
        $employee->name = $request->name;
        $employee->email = $request->email;
        $employee->phone = $request->phone;
        $employee->gender = $request->gender;
        $employee->age = $request->age;
        $employee->save();

        //Send message

        return response()->json([
            "status" => 1,
            "message" => "Employee created successfully"
        ]);

            //        Employee::create([
            //            "name" => $request->name
            //        ]);


    }

    //LIST API - GET
    //URL - http://localhost:8000/api/list-employees
    public function listEmployees()
    {
        //$employee = Employee::all();
        $employee = Employee::get();
        return response()->json([
            "status" => 1,
            "message" => "Listing Employees",
            "data" => $employee
        ], 200);
        //print_r($employee);
        //return $employee;

    }

    //GET SINGLE API - GET
    //URL - http://localhost:8000/api/single-employee/{id}
    public function getSingleEmployee($id)
    {
        if (Employee::where("id", $id)->exists()) {
            $employee_detail = Employee::where("id", $id)->first();
            return response()->json([
                "status" => 1,
                "message" => "Employee found",
                "data" => $employee_detail
            ], 200);
        } else {
            return response()->json([
                "status" => 0,
                "message" => "Employee not found"
            ], 404);
        };


    }

    //UPDATE API - PUT
    //URL - http://localhost:8000/api/update-employee/{id}
    public function updateEmployee(Request $request, $id)
    {
        if (Employee::where("id", $id)->exists()) {
            $employee = Employee::find($id);
            //If new value exist n not empty then we will update, else existing value will b updated i.e remain
            //We can't use full validation like d creating here
            $request->validate([
                "phone" => "max:11",
            ]);
            $employee->name = !empty($request->name) ? $request->name : $employee->name;
            $employee->email = !empty($request->email) ? $request->email : $employee->email;
            $employee->phone = !empty($request->phone) ? $request->phone : $employee->phone;
            $employee->gender = !empty($request->gender) ? $request->gender : $employee->gender;
            $employee->age = !empty($request->age) ? $request->age : $employee->age;;
            $employee->save();
            return response()->json([
                "status" => 1,
                "message" => "Employee updated successfully",
            ], 200);
        } else {
            return response()->json([
                "status" => 0,
                "message" => "Employee not found"
            ], 404);
        };
    }

    //DELETE API - DELETE
    //URL http://localhost:8000/api/delete-employee/{id}
    public function deleteEmployee($id)
    {
        if (Employee::where("id", $id)->exists()) {
            $employee = Employee::find($id);
            $employee->delete();
            return response()->json([
                "status" => 1,
                "message" => "Employee deleted successfully",
            ], 200);

        }else {
            return response()->json([
                "status" => 0,
                "message" => "Employee not found"
            ], 404);
        };

    }

}
