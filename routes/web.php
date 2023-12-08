<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\CompanyController; 
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
Route::group(['middleware'=>'guest'],function(){
    Route::get('/',[AuthController::class,'login'])->name('login');
    Route::post('/signin',[AuthController::class,'signin'])->name('signin');
});

Route::as('admin.')->middleware('is_admin')->prefix('admin')->group(function(){
    Route::get('dashboard',function(){return view('admin.dashboard.index');})->name('dashboard');
    Route::get('/signout',[AuthController::class,'signOut'])->name('signout');
    Route::resource('roles', RoleController::class);
    Route::get('user-list/{type}',[UserController::class,'getUser'])->name('user-role');
    Route::post('company-user',[CompanyController::class,'getCompanyUser'])->name('company-user');
    Route::resource('users', UserController::class);
    Route::resource('permissions', PermissionController::class);
    Route::resource('companies', CompanyController::class);
    
});