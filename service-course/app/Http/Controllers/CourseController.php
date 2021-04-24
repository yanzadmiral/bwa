<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use App\Models\Course;
use App\Models\Mentor;

class CourseController extends Controller
{
    public function index(Request $request)
    {
        $course = Course::query();
        return response()->json([
            'status'=> 'success',
            'data' => $course->paginate(10)
        ]);
    }

    public function show($id)
    {
        $mentor = Mentor::find($id);

        if (!$mentor) {
            return response()->json([
                'status'=> 'error',
                'data' => 'mentor not found'
            ], 404);
        }

        return response()->json([
            'status'=> 'success',
            'data' => $mentor
        ], 200);
    }

    public function create(Request $request)
    {
        $rule = [
            'name' => 'required|string',
            'certificate' => 'required|boolean',
            'thumbnail' => 'string|url',
            'type' => 'required|in:free,premium',
            'status' => 'required|in:draft,published',
            'price' => 'integer',
            'level' => 'required|in:all-level,beginer,intermediate,advance',
            'mentor_id' => 'required|integer',
            'description' => 'string',
        ];

        $data = $request->all();

        $validator = Validator::make($data,$rule);
        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => $validator->errors()
            ],400);
        }
       
        $mentorId = $request->input('mentor_id');
        $mentor = Mentor::find($mentorId);

        if (!$mentor) {
            return response()->json([
                'status'=> 'success',
                'data' => 'mentor not found'
            ], 404);
        }

        $course = Course::create($data);
        return response()->json([
            'status'=> 'success',
            'data' => $course
        ], 200);
    }

    public function update(Request $request, $id)
    {
        $rule = [
            'name' => 'string',
            'certificate' => 'boolean',
            'thumbnail' => 'string|url',
            'type' => 'in:free,premium',
            'status' => 'in:draft,published',
            'price' => 'integer',
            'level' => 'in:all-level,beginer,intermediate,advance',
            'mentor_id' => 'integer',
            'description' => 'string',
        ];

        $data = $request->all();

        $validator = Validator::make($data,$rule);
        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => $validator->errors()
            ],400);
        }
        $course = Course::find($id);


        if (!$course) {
            return response()->json([
                'status'=> 'error',
                'data' => 'Course not found'
            ], 404);
        }

        $mentorId = $request->input('mentor_id');
        $mentor = Mentor::find($mentorId);

        if (!$mentor) {
            return response()->json([
                'status'=> 'success',
                'data' => 'mentor not found'
            ], 404);
        }

        $course->fill($data);
        $course->save();

        return response()->json([
            'status'=> 'success',
            'data' => $course
        ], 200);
    }
}
