<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use App\Models\Course;
use App\Models\MyCourse;

class MyCourseController extends Controller
{

    public function index(Request $request)
    {
        $MyCourse = MyCourse::query()->with('course');

        $userId = $request->query('user_id');

        $MyCourse->when($userId,function($query) use ($userId)
        {   
            return $query->where("user_id","=",$userId);
        });

        return response()->json([
            'status'=> 'success',
            'data' => $MyCourse->get()
        ]);
    }


    public function create(Request $request)
    {
        $rule = [
            'course_id' => 'required|integer',
            'user_id' => 'required|integer',
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
        $course = Course::find($courseId);

        if (!$course) {
            return response()->json([
                'status'=> 'error',
                'message' => 'course not found'
            ], 404);
        }

        $userId = $request->input('user_id');
        $user = getUser($userId);

        if ($user['status'] === 'error') {
            return response()->json([
                'status'=> $user['status'],
                'message' => $user['message']
            ], $user['http_code']);
        }

        $isExistMyCourse = MyCourse::where('course_id','=',$courseId)
                                    ->where('user_id','=',$userId)
                                    ->exists();

        if ($isExistMyCourse) {
            return response()->json([
                'status'=> 'error',
                'message' => 'user already taken this course'
            ], 404);
        }
        
        if ($course->type === 'premium') {
            $order = postOrder([
                'course' => $course->toArray(),
                'user' => $user['data']
            ]);
            if ($order['status'] === 'error') {
                return response()->json([
                    'status'=> $order['status'],
                    'message' => $order['message']
                ], $order['http_code']);
            }
            return response()->json([
                'status' => $order['status'],
                'data' => $order['data']
            ]);
        }else {
            $mycourse = MyCourse::create($data);
            return response()->json([
                'status'=> 'success',
                'data' => $mycourse
            ], 200);
        }
    }

    public function createPremiumAccess(Request $request)
    {
        $data = $request->all();
        $mycourse = MyCourse::create($data);

        return response()->json([
            'status' => 'success',
            'data' => $mycourse
        ], 200);
    }
}
