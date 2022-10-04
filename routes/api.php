<?php

use App\Http\Controllers\Api\v1\AttachmentController;
use App\Http\Controllers\Api\v1\auth\AuthController;
use App\Http\Controllers\Api\v1\BoardController;
use App\Http\Controllers\Api\v1\CompanyController;
use App\Http\Controllers\Api\v1\EmployeeController;
use App\Http\Controllers\Api\v1\ProfileController;
use App\Http\Controllers\Api\v1\RegistrationController;
use App\Http\Controllers\Api\v1\BoardListController;
use App\Http\Controllers\Api\v1\CardController;
use App\Http\Controllers\Api\v1\ChangeCardListController;
use App\Http\Controllers\Api\v1\CommentController;
use App\Http\Controllers\Api\v1\LocalizationController;
use App\Http\Controllers\Api\v1\MemberController;
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

Route::group(['middleware'=>['auth:api','isActive']],function(){
    Route::get('/profile',[AuthController::class,'profile'])->name('profile.show');
    Route::post('/profile',ProfileController::class)->name('profile.update');

    Route::post('/logout',[AuthController::class,'logout'])->name('logout');
    Route::post('change_language',LocalizationController::class)->name('language.change');

   

    Route::group(['middleware'=>['role:owner']],function (){

        Route::patch('/company/{company}',CompanyController::class);
        Route::apiResource('/employees',EmployeeController::class)->except('index');
        Route::get('employees',[EmployeeController::class,'index']);

        ###################### Board Routes #################################################

        Route::get('boards',[BoardController::class,'index'])->name('boards.index');
        Route::post('boards',[BoardController::class,'store'])->name('boards.store');
        Route::get('boards/{board}',[BoardController::class,'show'])->name('boards.show');
        Route::patch('boards/{board}',[BoardController::class,'update'])->name('boards.update');
        Route::delete('boards/{board}',[BoardController::class,'destroy'])->name('boards.delete');

        ######################################################################################################

        ###################### List Routes #################################################

        Route::post('boards/{board}/list',[BoardListController::class,'store'])->name('list.store');
        Route::patch('boards/{board}/list/{list}',[BoardListController::class,'update'])->name('list.update');
        Route::delete('boards/{board}/list/{list}',[BoardListController::class,'destroy'])->name('list.delete');
                
        ######################################################################################################
        ####################### Card Route ###################################################################
        Route::post('boards/{board}/list/{list}/card',[CardController::class,'store'])->name('card.store');
        Route::patch('boards/{board}/list/{list}/card/{card}',[CardController::class,'update'])->name('card.update');
        Route::delete('boards/{board}/list/{list}/card/{card}',[CardController::class,'destroy'])->name('card.delete');

        ######################################################################################################
        Route::post('boards/{board}/list/{list}/card/{card}/members',[MemberController::class,'assign'])->name('member.store');
        Route::delete('boards/{board}/list/{list}/card/{card}/members',[MemberController::class,'destroy'])->name('member.delete');
        #######################################################################################################









    });

    Route::group(['middleware'=>['role:employee|owner']],function(){
    ####################### List Route #######################################
    Route::get('boards/{board}/list',[BoardListController::class,'index'])->name('list.index');
    Route::get('boards/{board}/list/{list}',[BoardListController::class,'show'])->name('list.show');
    ##########################################################################
    ####################### Card Route #######################################
    Route::get('boards/{board}/list/{list}/card',[CardController::class,'index'])->name('card.index');
    Route::get('boards/{board}/list/{list}/card/{card}',[CardController::class,'show'])->name('card.show');


    ########################### chang card list ##############################
    Route::post('boards/{board}/list/{list}/card/{card}',ChangeCardListController::class)->name('card.change');
    ##########################################################################
    Route::get('boards/{board}/list/{list}/card/{card}/members',[MemberController::class,'index'])->name('member.index');

    ########################## comment routes#################################
    Route::get('boards/{board}/list/{list}/card/{card}/comment',[CommentController::class,'index'])->name('comment.index');
    Route::post('boards/{board}/list/{list}/card/{card}/comment',[CommentController::class,'store'])->name('comment.store');
    Route::get('boards/{board}/list/{list}/card/{card}/comment/{comment}',[CommentController::class,'show'])->name('comment.show');
    Route::patch('boards/{board}/list/{list}/card/{card}/comment/{comment}',[CommentController::class,'update'])->name('comment.update');
    Route::delete('boards/{board}/list/{list}/card/{card}/comment/{comment}',[CommentController::class,'destroy'])->name('comment.delete');
    #################################################################################
    ##########################   Attachment Route    ##################################################
    ###################################################################################################
    Route::post('boards/{board}/list/{list}/card/{card}/attachment',[AttachmentController::class,'store'])->name('attachment.store');
    Route::patch('boards/{board}/list/{list}/card/{card}/attachment',[AttachmentController::class,'update'])->name('attachment.update');
    Route::delete('boards/{board}/list/{list}/card/{card}/attachment/{attachment}',[AttachmentController::class,'destroy'])->name('attachment.delete');
    Route::get('boards/{board}/list/{list}/card/{card}/attachment/{attachment}',[AttachmentController::class,'show'])->name('attachment.delete');










    });
});
