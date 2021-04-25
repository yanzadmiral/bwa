<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use App\Models\ImageCourse;
use App\Models\Course;

class ImageCourseController extends Controller
{
    public function create(Request $request)
    {
        $rule = [
            'image' => 'required|string',
            'course_id' => 'required|integer'
        ];

        $data = $request->all();

        $validator = Validator::make($data,$rule);
        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => $validator->errors()
            ],400);
        }

        $courseId = $request->input('course_id');
        $course = course::find($courseId);

        if (!$course) {
            return response()->json([
                'status'=> 'error',
                'message' => 'course not found'
            ], 404);
        }

        $ImageCourse = ImageCourse::create($data);
        return response()->json([
            'status'=> 'success',
            'data' => $ImageCourse
        ], 200);
    }

    public function destroy($id)
    {
        $ImageCourse = ImageCourse::find($id);
        if (!$ImageCourse) {
            return response()->json([
                'status'=> 'error',
                'message' => 'Image Course not found'
            ], 404);
        }
        $ImageCourse->delete();

        return response()->json([
            'status'=> 'success',
            'data' => 'Image Course deleted'
        ], 200);
    }
}
