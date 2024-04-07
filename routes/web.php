<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\TournamentController;
use App\Http\Controllers\FormController;
use App\Http\Controllers\FormQuestionSectionController;
use App\Http\Controllers\FormQuestionController;
use App\Http\Controllers\RuleController;
use App\Http\Controllers\FormViewController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::get('/', [AuthController::class, 'index'])->name('login');

   
Route::get('login', [AuthController::class, 'index'])->name('login');
Route::post('post-login', [AuthController::class, 'postLogin'])->name('login.post'); 
Route::get('registration', [AuthController::class, 'registration'])->name('register');
Route::post('post-registration', [AuthController::class, 'postRegistration'])->name('register.post'); 

//vineetha//

Route::group(['middleware' => ['auth:web']], function() {
    Route::get('dashboard', [AuthController::class, 'dashboard'])->name('dashboard');
    Route::any('logout', [AuthController::class, 'logout'])->name('logout');
    Route::get('/changePassword', [AuthController::class, 'changePassword'])->name('changePassword');
    Route::post('/password_reset', [AuthController::class, 'password_reset'])->name('password_reset');

    Route::get('admin', [AdminController::class, 'index'])->name('admin');
    Route::get('admin/create', [AdminController::class, 'create'])->name('admin.create');
    Route::post('admin/create', [AdminController::class, 'store'])->name('admin.store');
    Route::delete('admin/delete/{id}', [AdminController::class, 'destroy'])->name('admin.delete');
    Route::get('admin/status/{id}', [AdminController::class, 'changeStatus'])->name('admin.status');
    Route::get('admin/tournaments', [AdminController::class, 'tournaments'])->name('admin.tournaments');

    Route::get('user', [UserController::class, 'index'])->name('user');
    Route::get('user/create', [UserController::class, 'create'])->name('user.create');
    Route::post('user/create', [UserController::class, 'store'])->name('user.store');
    Route::delete('user/delete/{id}', [UserController::class, 'destroy'])->name('user.delete');
    Route::get('user/status/{id}', [UserController::class, 'changeStatus'])->name('user.status');

    Route::get('role', [RoleController::class, 'index'])->name('role');
    Route::get('role/create', [RoleController::class, 'create'])->name('role.create');
    Route::post('role/create', [RoleController::class, 'store'])->name('role.store');
    Route::delete('role/delete/{id}', [RoleController::class, 'destroy'])->name('role.delete');

    Route::get('tournament', [TournamentController::class, 'index'])->name('tournament');
    Route::get('tournament/create', [TournamentController::class, 'create'])->name('tournament.create');
    Route::post('tournament/create', [TournamentController::class, 'store'])->name('tournament.store');
    Route::delete('tournament/delete/{id}', [TournamentController::class, 'destroy'])->name('tournament.delete');

    Route::get('form', [FormController::class, 'index'])->name('form');
    Route::get('form/create', [FormController::class, 'create'])->name('form.create');
    Route::post('form/create', [FormController::class, 'store'])->name('form.store');
    Route::delete('form/delete/{id}', [FormController::class, 'destroy'])->name('form.delete');
    Route::get('form/imageDelete/{id}', [FormController::class, 'imageDelete'])->name('form.imageDelete');
    
    Route::get('form/formQuestionSection', [FormQuestionSectionController::class, 'index'])->name('formQuestionSection');
    Route::get('formQuestionSection/create', [FormQuestionSectionController::class, 'create'])->name('formQuestionSection.create');
    Route::post('formQuestionSection/create', [FormQuestionSectionController::class, 'store'])->name('formQuestionSection.store');
    Route::delete('formQuestionSection/delete', [FormQuestionSectionController::class, 'destroy'])->name('formQuestionSection.delete');
    
    Route::get('form/formQuestion', [FormQuestionController::class, 'index'])->name('formQuestion');
    Route::get('formQuestion/create', [FormQuestionController::class, 'create'])->name('formQuestion.create');
    Route::post('formQuestion/create', [FormQuestionController::class, 'store'])->name('formQuestion.store');
    Route::delete('formQuestion/delete', [FormQuestionController::class, 'destroy'])->name('formQuestion.delete');

    Route::get('rule', [RuleController::class, 'index'])->name('rule');
    Route::get('rule/create', [RuleController::class, 'create'])->name('rule.create');
    Route::post('rule/create', [RuleController::class, 'store'])->name('rule.store');
    Route::delete('rule/delete/{id}', [RuleController::class, 'destroy'])->name('rule.delete');
    
    Route::get('formview', [FormViewController::class, 'index'])->name('formview');
    Route::get('formview/list', [FormViewController::class, 'formslist'])->name('formview.list');
    Route::get('formview/details', [FormViewController::class, 'formsDetails'])->name('formview.details');


});


//vineetha//
    
   
