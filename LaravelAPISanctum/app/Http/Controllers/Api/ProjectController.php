<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Project;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    //CREATE PROJECT API - POST
    //URL http://localhost:8000/api/create-project
    public function createProject(Request $request)
    {
        $request->validate([
            "name" => "required",
            "description" => "required",
            "duration" => "required"
        ]);

        //Student id + create data
        $student_id = auth()->user()->id;
        $project = new Project();

        $project->student_id = $student_id;
        $project->name = $request->name;
        $project->description = $request->description;
        $project->duration = $request->duration;
        $project->save();

        //send response
        return response()->json([
            "message" => "Project Created Successfully",
        ], 200);

        //HEADER
        // Content Type - application/json, Accept - application/json
        //Authorization - Bearer token of the logged-in user

        //BODY
        //{
        //    "name" : " Project 1",
        //    "description" : "Content of project 1",
        //    "duration" : 6
        //}

    }

    //LIST PROJECT API - GET
    //URL http://localhost:8000/api/list-project
    public function listProject()
    {
        $student_id = auth()->user()->id;
        $projects = Project::where("student_id", $student_id)->get();

        return response()->json([
            "message" => "Projects",
            "data" => $projects
        ], 200);
        //HEADER
        // Content Type - application/json, Accept - application/json
        //Authorization - Bearer token of the logged-in user


    }

    //SINGLE PROJECT API
    //URL http://localhost:8000/api/single-project/{id}
    public function singleProject($id)
    {
        $student_id = auth()->user()->id;
        if (Project::where(["id" => $id, "student_id" => $student_id])->exists()) {

            $details = Project::where(["id" => $id, "student_id" => $student_id])->first();

            return response()->json([
                "message" => "Project detail",
                "data" => $details
            ], 200);

        } else {
            return response()->json([
                "message" => "Project not found",
            ], 404);
        }
        //URL http://localhost:8000/api/single-project/2
        //HEADER
        // Content Type - application/json, Accept - application/json
        //Authorization - Bearer token of the logged-in user

    }

    //DELETE PROJECT API - DELETE
    //URL http://localhost:8000/api/delete-project/{id}
    public function deleteProject($id)
    {
        $student_id = auth()->user()->id;
        if (Project::where(["id" => $id, "student_id" => $student_id])->exists()) {

            $project = Project::where(["id" => $id, "student_id" => $student_id])->first();

            $project->delete();

            return response()->json([
                "message" => "Project deleted successfully",
            ], 200);

        } else {
            return response()->json([
                "message" => "Project not found",
            ], 404);
        }
        //http://localhost:8000/api/delete-project/5
        //To copy headers, click Bulk edit on postman
    }
}
