<?php

use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\FormController;
use App\Http\Controllers\API\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::controller(AuthController::class)->group(function () {
    Route::post('login', 'login');
    Route::post('register', 'register');
    Route::post('logout', 'logout');
    Route::post('refresh', 'refresh');
    Route::post('user_password_change', 'changePassword');
});

Route::controller(UserController::class)->group(function () {
    Route::post('user_access_list', 'userAccessList');
    Route::post('user_form_list', 'userFormList');
    Route::post('user_form_answer_submit', 'userFormAnswerSubmit');
});

Route::controller(FormController::class)->group(function () {
    Route::post('form_questions', 'formQuestions');
    Route::post('change_form_status', 'changeFormStatus');
    Route::post('admin_form_questions', 'adminFormQuestions');
});