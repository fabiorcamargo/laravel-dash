<?php

use App\Http\Controllers\ApiController;
use App\Http\Controllers\ApiWhatsapp;
use App\Http\Controllers\ChatbotAsset;
use Illuminate\Auth\Middleware\Authorize;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;

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
Route::post('chatbot/chat_pro', [ApiController::class, 'chatbot_chat_pro'])->name('api.chatbot.chat_pro');
Route::post('chatbot/test', [ApiController::class, 'chatbot_test']);
//Route::post('chatbot/queue', [ChatbotAsset::class, 'chatbot_convert_data']);

Route::any('rd', function (Request $request) {
    $data = json_encode(($request));
    Storage::put('rd.txt', $data);
    return response('',200);
	});

    Route::prefix('wp_api')->group(function () {
        Route::prefix('msg')->group(function () {
        Route::any('receive', [ApiWhatsapp::class, 'msg_receive'])->name('wp_api.msg_receive'); 
        });
    });