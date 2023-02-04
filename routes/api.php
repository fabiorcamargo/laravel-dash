<?php

use App\Http\Controllers\ApiController;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('users', [ApiController::class, 'getAllUsers'])->name('api.cademi.users'); 
Route::post('users/store', [ApiController::class, 'store'])->name('api.cademi.store'); 
Route::post('course/store', [ApiController::class, 'course_store'])->name('api.cademi.course.store'); 
Route::post('gateway/pay', [ApiController::class, 'gateway_pay_post'])->name('api.gateway.pay.post');

Route::post('chatbot/pre_hen', [ApiController::class, 'chatbot_pre_hen'])->name('api.chatbot.pre_hen');
