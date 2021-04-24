<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MentorController;
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
Route::post('mentors',[MentorController::class,'create']);
Route::put('mentors/{id}',[MentorController::class,'update']);
Route::delete('mentors/{id}',[MentorController::class,'destroy']);