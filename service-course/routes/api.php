<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MentorController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\ChapterController;
use App\Http\Controllers\LessonController;
use App\Http\Controllers\ImageCourseController;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::get('mentors',[MentorController::class,'index']);
Route::get('mentors/{id}',[MentorController::class,'show']);
Route::put('mentors/{id}',[MentorController::class,'update']);
Route::delete('mentors/{id}',[MentorController::class,'destroy']);


Route::get('courses',[CourseController::class,'index']);
Route::post('courses',[CourseController::class,'create']);
Route::put('courses/{id}',[CourseController::class,'update']);
Route::delete('courses/{id}',[CourseController::class,'destroy']);


Route::get('chapters',[ChapterController::class,'index']);
Route::get('chapters/{id}',[ChapterController::class,'show']);
Route::post('chapters',[ChapterController::class,'create']);
Route::put('chapters/{id}',[ChapterController::class,'update']);
Route::delete('chapters/{id}',[ChapterController::class,'destroy']);


Route::get('lessons',[LessonController::class,'index']);
Route::get('lessons/{id}',[LessonController::class,'show']);
Route::post('lessons',[LessonController::class,'create']);
Route::put('lessons/{id}',[LessonController::class,'update']);
Route::delete('lessons/{id}',[LessonController::class,'destroy']);


Route::post('image-courses',[ImageCourseController::class,'create']);
