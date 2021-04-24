<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

use App\Models\Mentor;

class MentorController extends Controller
{
    public function create(Request $request)
    {
        $rule = [
            'name' => 'required|string',
            'profile' => 'required|url',
            'profession' => 'required|string',
            'email' => 'required|email',
        ];

        $data = $request->all();

        $validator = Validator::make($data,$rule);
        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => $validator->errors()
            ],400);
        }
        $mentor = Mentor::create($data);


        return response()->json([
            'status'=> 'success',
            'data' => $mentor
        ], 200);
    }
}
