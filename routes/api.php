<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::namespace('Account')->name('account.')->group(function () {
    Route::post('/loginByEmail', 'LoginApiController@loginByEmail')->name('login_by_email');
});

Route::namespace('Assign')->name('assign.')->group(function () {
    Route::get('/getLearners/{classId}', 'AssignEngineerApiController@getEnrollableLearners')->name('get_enrollable_learners');
    Route::post('/withdrawLearner/{classId}/{userId}', 'AssignEngineerApiController@withdrawLearnerFromClass')->name('enroll_learner');
    Route::post('/enrollLearners/{classId}/{userId}', 'AssignEngineerApiController@enrollLearners')->name('enroll_learner');
    Route::get('/getEnrolledUser/{classId}', 'AssignEngineerApiController@getEnrolledUsersInClass')->name('get_enrolled_user');
});
