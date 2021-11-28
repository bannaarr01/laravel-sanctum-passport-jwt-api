<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\User;
use http\Env\Response;
use Illuminate\Http\Request;

class CourseController extends Controller
{
    //POST ENROLMENT API - POST
    // URL http://localhost:8000/api/course-enrol
    public function courseEnrollment(Request $request){
        $request->validate([
            'title' => 'required',
            'description' => 'required',
            'total_videos' => 'required'
        ]);

        $course = new Course();
        $course->user_id = auth()->user()->id;
        $course->title = $request->title;
        $course->description = $request->description;
        $course->total_videos = $request->total_videos;
        $course->save();

        return response()->json([
            "status" => "success",
            "message" => "Course Enroll Successfully"
        ], 201);

    }

    //TOTAL COURSES ENROLLED API - GET
    // URL http://localhost:8000/api/total-courses
    public function totalCourses(){
        $id = auth()->user()->id;
        //Get all the courses enrolled by this user
        $courses = User::find($id)->courses; //<--ds is d course relationship inside user Model

        return response()->json([
            "status" => "success",
            "message" => "Total courses enrolled by ".auth()->user()->name,
            "data" => $courses
        ], 200);
    }

    //DELETE COURSE API - GET
    // URL http://localhost:8000/api/delete-corse/{id}
    public function deleteCourse($id){
        $user_id = auth()->user()->id;

        if(Course::where(["id" => $id, "user_id" => $user_id])->exists()){

            $course = Course::find($id);

            $course->delete();

            return response()->json([
                "status" => "success",
                "message" => "Course deleted successfully"
            ], 200);
        }else{
            return response()->json([
                "status" => 0,
                "message" => "Course not found"
            ], 404);
        }
    }

}
