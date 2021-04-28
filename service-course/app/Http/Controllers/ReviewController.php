<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use App\Models\Review;
use App\Models\Course;

class ReviewController extends Controller
{

    public function create(Request $request)
    {
        $rule = [
            'user_id' => 'required|integer',
            'course_id' => 'required|integer',
            'rating' => 'required|integer|min:1|max:5',
            'note' => 'string',
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

        $isExistReview = Review::where('course_id','=',$courseId)
                                    ->where('user_id','=',$userId)
                                    ->exists();

        if ($isExistReview) {
            return response()->json([
                'status'=> 'error',
                'message' => 'user already taken this review'
            ], 404);
        }
        
        $Review = Review::create($data);
        return response()->json([
            'status'=> 'success',
            'data' => $Review
        ], 200);
    }

    public function update(Request $request, $id)
    {
        $rule = [
            'rating' => 'required|integer|min:1|max:5',
            'note' => 'required|string',
        ];

        $data = $request->except('user_id','course_id');

        $validator = Validator::make($data,$rule);
        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => $validator->errors()
            ],400);
        }
       
       $Review = Review::find($id);

       if (!$Review) {
        return response()->json([
            'status' => 'error',
            'message' => "review not found"
        ],404);
       }

       $Review->fill($data);
       $Review->save();

       return response()->json([
            'status' => 'success',
            'data' => $Review
        ],200);
    }    
}
