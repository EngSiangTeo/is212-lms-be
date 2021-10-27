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
    Route::get('/getAllClasses', 'AssignEngineerApiController@getListOfAllClasses')->name('get_all_classes');
    Route::post('/assignTrainer/{classId}/{userId}', 'AssignEngineerApiController@setClassTrainer')->name('assign_trainer');
});

Route::namespace('SelfEnroll')->name('selfenroll.')->group(function () {
    Route::get('/getAvailableClasses/{userId}', 'SelfEnrollApiController@getListOfAvailableClasses')->name('get_available_classes');
    Route::post('/applyToClass/{classId}/{userId}', 'SelfEnrollApiController@applyToClass')->name('apply_to_class');
});

Route::namespace('Quiz')->name('quiz.')->group(function () {
    Route::post('/createQuiz/{sectionId}', 'QuizApiController@createQuizForSection')->name('create_quiz');
    Route::post('/createQuestion/{sectionId}', 'QuizApiController@createQuestionForSection')->name('create_quiz_question');
});

Route::namespace('Learn')->name('learn.')->group(function () {
    Route::get('/takeCourse/{userId}/{classId}', 'TakeCourseApiController@viewCourseMaterial')->name('take_course');
    Route::post('/takeQuiz/{userId}/{sectionId}', 'TakeCourseApiController@takeQuizAssessment')->name('take_quiz');
    Route::get('/viewQuizScore/{userId}/{attemptId}', 'TakeCourseApiController@viewQuizScoreAndAnswer')->name('view_quiz_score');
    Route::get('/viewQuiz/{userId}/{sectionId}', 'TakeCourseApiController@viewQuizQuestions')->name('view_quiz');
    Route::get('/viewQuizAttempts/{userId}/{sectionId}', 'TakeCourseApiController@viewQuizAttempts')->name('view_quiz');
    Route::get('/viewUserCourse/{userId}', 'TakeCourseApiController@viewUserCourses')->name('view_user_course');
});
