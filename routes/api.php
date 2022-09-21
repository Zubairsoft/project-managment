<?php

use App\Http\Controllers\Api\v1\auth\AuthController;
use App\Http\Controllers\Api\v1\CompanyController;
use App\Http\Controllers\Api\v1\EmployeeController;
use App\Http\Controllers\Api\v1\ProfileController;
use App\Http\Controllers\Api\v1\RegistrationController;
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

Route::post('/registration',RegistrationController::class)->name('company.register');
Route::post('/login',[AuthController::class,'login'])->name('login');

Route::group(['middleware'=>'auth:api'],function(){
    Route::get('/profile',[AuthController::class,'profile'])->name('profile.show');
    Route::post('/profile',ProfileController::class)->name('profile.update');

    Route::post('/logout',[AuthController::class,'logout'])->name('logout');

    Route::group(['middleware'=>['role:owner']],function (){

        Route::apiResource('/company',CompanyController::class)->except('store');
        Route::apiResource('/employees',EmployeeController::class)->except('index');
        Route::get('employees',[EmployeeController::class,'index']);

    });
});
