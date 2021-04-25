<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use App\Models\Lesson;
use App\Models\Chapter;

class LessonController extends Controller
{
    // public function index(Request $request)
    // {
    //     $Chapter = Chapter::query();

    //     $courseId = $request->query('course_id');

    //     $Chapter->when($courseId,function($query) use ($courseId)
    //     {   
    //         return $query->where("course_id","=",$courseId);
    //     });

    //     return response()->json([
    //         'status'=> 'success',
    //         'data' => $Chapter->get()
    //     ]);
    // }

    // public function show($id)
    // {
    //     $Chapter = Chapter::find($id);

    //     if (!$Chapter) {
    //         return response()->json([
    //             'status'=> 'error',
    //             'message' => 'chapter not found'
    //         ]);
    //     }

    //     return response()->json([
    //         'status'=> 'success',
    //         'data' => $Chapter
    //     ]);
    // }

    public function create(Request $request)
    {
        $rule = [
            'name' => 'required|string',
            'video' => 'required|string',
            'chapter_id' => 'required|integer',
            
        ];

        $data = $request->all();

        $validator = Validator::make($data,$rule);
        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => $validator->errors()
            ],400);
        }
       
        $chapterId = $request->input('chapter_id');
        $chapter = Chapter::find($chapterId);

        if (!$chapter) {
            return response()->json([
                'status'=> 'error',
                'data' => 'chapter not found'
            ], 404);
        }

        $lesson = Lesson::create($data);
        return response()->json([
            'status'=> 'success',
            'data' => $lesson
        ], 200);
    }

    // public function update(Request $request, $id)
    // {
    //     $rule = [
    //         'name' => 'string',
    //         'course_id' => 'integer',
            
    //     ];

    //     $data = $request->all();

    //     $validator = Validator::make($data,$rule);
    //     if ($validator->fails()) {
    //         return response()->json([
    //             'status' => 'error',
    //             'message' => $validator->errors()
    //         ],400);
    //     }
    //     $Chapter = Chapter::find($id);


    //     if (!$Chapter) {
    //         return response()->json([
    //             'status'=> 'error',
    //             'data' => 'Chapter not found'
    //         ], 404);
    //     }

    //     $CourseId = $request->input('course_id');
    //     $Course = Course::find($CourseId);

    //     if (!$Course) {
    //         return response()->json([
    //             'status'=> 'error',
    //             'data' => 'Course not found'
    //         ], 404);
    //     }

    //     $Chapter->fill($data);
    //     $Chapter->save();

    //     return response()->json([
    //         'status'=> 'success',
    //         'data' => $Chapter
    //     ], 200);
    // }

    // public function destroy($id)
    // {
    //     $chapter = Chapter::find($id);
    //     if (!$chapter) {
    //         return response()->json([
    //             'status'=> 'error',
    //             'data' => 'chapter not found'
    //         ], 404);
    //     }
    //     $chapter->delete();

    //     return response()->json([
    //         'status'=> 'success',
    //         'data' => 'chapter deleted'
    //     ], 200);
    // }
}
