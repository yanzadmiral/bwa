<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use App\Models\Course;
use App\Models\Mentor;
use App\Models\Review;
use App\Models\Chapter;
use App\Models\MyCourse;

class CourseController extends Controller
{
    public function index(Request $request)
    {
        $course = Course::query();

        $q = $request->query('q');
        $status = $request->query('status');

        $course->when($q,function($query) use ($q)
        {   
            return $query->whereRaw("name LIKE '%".strtolower($q)."%'");
        });

        $course->when($status,function($query) use ($status)
        {   
            return $query->where("status","=",$status);
        });

        return response()->json([
            'status'=> 'success',
            'data' => $course->paginate(10)
        ]);
    }
    public function show($id)
    {   
        $course = Course::with('mentor')->with('chapters.lessons')->with('images')->find($id);
        if (!$course) {
            return response()->json([
                'status'=> 'error',
                'message' => 'course not found'
            ], 404);
        }

        $reviews = Review::where('course_id','=',$id)->get()->toArray();

        if (count($reviews) >  0) {
            $userIds = array_column($reviews,'user_id');
            $users = getUserByIds($userIds);
            if ($users['status'] === 'error') {
                $reviews = [];
            }else{
                foreach ($reviews as $key => $review) {
                    $userIndex = array_search($review['user_id'],array_column($users['data'],'id'));
                    $reviews[$key]['users'] = $users['data'][$userIndex];
                }
            }
        }

        $totalstudent = MyCourse::where('course_id','=',$id)->count();
        $totalvideos = Chapter::where('course_id','=',$id)->withCount('lessons')->get()->toArray();
        $finaltotalvideos = array_sum(array_column($totalvideos,'lessons_count'));

        //print_r($totalvideos);
        $course['reviews'] = $reviews;
        $course['total_videos'] = $finaltotalvideos;
        $course['total_student'] = $totalstudent;

        return response()->json([
            'status'=> 'success',
            'data' => $course
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
                'status'=> 'error',
                'message' => 'mentor not found'
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
                'message' => 'Course not found'
            ], 404);
        }

        $mentorId = $request->input('mentor_id');
        $mentor = Mentor::find($mentorId);

        if (!$mentor) {
            return response()->json([
                'status'=> 'error',
                'message' => 'mentor not found'
            ], 404);
        }

        $course->fill($data);
        $course->save();

        return response()->json([
            'status'=> 'success',
            'data' => $course
        ], 200);
    }
    public function destroy($id)
    {
        $course = Course::find($id);
        if (!$course) {
            return response()->json([
                'status'=> 'error',
                'message' => 'course not found'
            ], 404);
        }
        $course->delete();

        return response()->json([
            'status'=> 'success',
            'data' => 'course deleted'
        ], 200);
    }
}
