<?php

use App\Http\Controllers\Api\auth\AuthController;
use App\Http\Controllers\Api\RegistrationController;
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
    Route::post('/logout',[AuthController::class,'logout'])->name('logout');
});
