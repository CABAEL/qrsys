<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\UserController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\LogoutController;


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

Route::get('/index',function(){
    return session()->get('user_data');
});


Route::post('login_post',[LoginController::class,'authenticate']);

Route::post('adduser',[UserController::class,'store']);

Route::middleware(['auth:sanctum'])->group(function () {
    Route::resource('user',UserController::class);
    Route::get('/logout',[LogoutController::class,'logout_user']);

    Route::get('/home',function(){
        return view('index');
    });


    Route::get('/check',function(){
        return Auth::id();
    });
});

Route::get('/invalidUser',function(){
    
    $data = [
        'status' => 'Invalid request.',
        'message' => 'Access denied.',
    ];

    return response()->json($data);

})->name('invalidUser');






