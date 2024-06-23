<?php

use App\Http\Controllers\ApiController;
use App\Http\Controllers\ApiWhatsapp;
use App\Models\User;
use App\Models\WpGroup;
use Dotenv\Exception\ValidationException;
use Illuminate\Auth\Middleware\Authorize;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
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

Route::post('token', function (Request $request) {

    $request->validate([
        'username' => 'required|string',
        'password' => 'required|string',
    ]);

    $user = User::where('username', $request->username)->first();

    dd(Hash::check($request->password, $user->password));

    if (!$user || !Hash::check($request->password, $user->password)) {
        throw ValidationException::withMessages([
            'username' => ['The provided credentials are incorrect.'],
        ]);
    }

    $token = $user->createToken('auth_token')->plainTextToken;

    return response()->json(['access_token' => $token, 'user' => $user]);
});

Route::middleware('auth:sanctum')->group(function () {

Route::get('/user', function (Request $request) {
    return $request->user();
});

});



Route::get('groups', function () {
    $wg = WpGroup::with('wpGroupCategory')->get();

    if ($wg->isEmpty()) {
        return response()->json(['message' => 'No groups found'], Response::HTTP_NOT_FOUND);
    }

    return response()->json($wg, Response::HTTP_OK);
});

Route::post('users', [ApiController::class, 'getAllUsers'])->name('api.cademi.users');
Route::post('users/store', [ApiController::class, 'store'])->name('api.cademi.store');
Route::post('course/store', [ApiController::class, 'course_store'])->name('api.cademi.course.store');
Route::post('gateway/pay', [ApiController::class, 'gateway_pay_post'])->name('api.gateway.pay.post');

Route::post('chatbot/pre_hen', [ApiController::class, 'chatbot_pre_hen'])->name('api.chatbot.pre_hen');
Route::post('chatbot/chat_pro', [ApiController::class, 'chatbot_chat_pro'])->name('api.chatbot.chat_pro');
Route::post('chatbot/test', [ApiController::class, 'chatbot_test']);

Route::get('pay/status/{id}', [ApiController::class, 'pay_status']);
//Route::post('chatbot/queue', [ChatbotAsset::class, 'chatbot_convert_data']);

Route::any('rd', function (Request $request) {
    $data = json_encode(($request));
    Storage::put('rd.txt', $data);
    return response('', 200);
});

Route::prefix('wp_api')->group(function () {
    Route::prefix('msg')->group(function () {
        Route::any('receive', [ApiWhatsapp::class, 'msg_receive'])->name('wp_api.msg_receive');
        Route::get('correct', [ApiWhatsapp::class, 'correct_type_msg'])->name('wp_api.msg_receive');
    });
});

Route::post('/asaas-status', function (Request $request) {
    $content = json_encode($request->all());
    Storage::disk('local')->append('asaas.txt', $content);
})->name('asaas-status');
