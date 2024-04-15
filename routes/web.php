<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\ActivityController;
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

Route::as('admin.')->middleware(['is_admin', 'is_join'])->prefix('admin')->group(function(){
    Route::get('dashboard',[UserController::class,'dashboard'])->name('dashboard');
    Route::get('join',[AuthController::class,'join'])->name('join');
    Route::get('join-as/{role}',[AuthController::class,'joinAs'])->name('join-as');
    Route::get('profile',[UserController::class,'profile'])->name('profile');
    Route::post('update-profile',[UserController::class,'updateProfile'])->name('update-profile');
    Route::get('switch/{role}',[UserController::class,'switch'])->name('switch');

    Route::get('signout',[AuthController::class,'signOut'])->name('signout');
    Route::resource('roles', RoleController::class);
    Route::get('user-list/{type}',[UserController::class,'getUser'])->name('user-role');
    Route::post('company-user',[CompanyController::class,'getCompanyUser'])->name('company-user');
    Route::resource('users', UserController::class);
    Route::resource('permissions', PermissionController::class);

    // Route::get('companies/{sale_type}',[CompanyController::class,'index'])->name('company.index');
    // Route::get('company/create/{sale_type}',[CompanyController::class,'create'])->name('company.create');
    Route::resource('companies', CompanyController::class);
    Route::post('send-company-otp', [CompanyController::class,'sendCompanyOTP'])->name('send-company-otp');
    Route::post('verify-company-otp', [CompanyController::class,'verifyCompanyOTP'])->name('verify-company-otp');
    // Route::get('company/register',[CompanyController::class,'register'])->name('register-company');
    Route::get('history',[ActivityController::class,'index'])->name('history.index');

    Route::post('send-otp/{method}', [AuthController::class,'sendOtp'])->where('method', 'register|login')->name('send-otp');

});




Route::get('command/{command}', function ($command){
    if($command == 'reset'){
        \Illuminate\Support\Facades\Artisan::call('view:clear');
        $result = \Illuminate\Support\Facades\Artisan::output();
        dump($result);

        \Illuminate\Support\Facades\Artisan::call('route:clear');
        $result = \Illuminate\Support\Facades\Artisan::output();
        dump($result);

        \Illuminate\Support\Facades\Artisan::call('cache:clear');
        $result = \Illuminate\Support\Facades\Artisan::output();
        dump($result);

        \Illuminate\Support\Facades\Artisan::call('config:clear');
        $result = \Illuminate\Support\Facades\Artisan::output();
        dump($result);

        \Illuminate\Support\Facades\Artisan::call('config:cache');
        $result = \Illuminate\Support\Facades\Artisan::output();
        dump($result);
        die;
    }else{
        \Illuminate\Support\Facades\Artisan::call($command);
        $result = \Illuminate\Support\Facades\Artisan::output();
    }
    dd($result);

})->name('command.run');
