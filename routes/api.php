<?php

use App\Http\Controllers\ApiAppController;
use App\Http\Controllers\ApiController;
use App\Http\Controllers\ApiGetCourses;
use App\Http\Controllers\ApiGetOuroCourses;
use App\Http\Controllers\ApiWhatsapp;
use App\Http\Controllers\OldAsaasController;
use App\Http\Controllers\TemporaryFileController;
use App\Models\City;
use App\Models\State;
use App\Models\User;
use App\Models\WpGroup;

use Illuminate\Auth\Middleware\Authorize;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;

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
    $user->client_ouro;
    $user->cademis;

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
        $user = $request->user();
        $user->client_ouro;
        $user->cademis;

        return $request->user();
    });

    Route::post('/avatar',  [TemporaryFileController::class, 'AvatarUploadApi']);

    Route::put('/user', function (Request $request) {

        $user = $request->user();

     
        //  // Validação do arquivo de imagem
        //  $request->validate([
        //     'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        // ]);

        // Debug do arquivo enviado
        dd($request->file('image'));

        foreach ($request->all() as $key => $param) {

            if ($key == 'cellphone') {
                $param = preg_replace('/[^0-9]/', '', $param);
                
                if (strpos($param, '55') === 0) {
                    // Remove o prefixo apenas se estiver presente no início da string
                    $param = substr($param, 2);
                }
            }

            if ($key == 'img') {
                dd($param);
            }
            $user->$key = $param;
        }
        $user->save();


        return response()->json(['user' => $request->user()], Response::HTTP_OK);
    });

    Route::get('/sellers', [OldAsaasController::class, 'getSellers']);

    Route::get('/get_cademi_course', [ApiGetCourses::class, 'getCademiCourses']);
    Route::get('/get_cademi_courseslist', [ApiGetCourses::class, 'getCademiCoursesList']);
    Route::get('/get_ouro_course', [ApiGetOuroCourses::class, 'getOuroCourses']);

    Route::resource('/appPost', ApiAppController::class);
    Route::get('/getByCourse/{course}', [ApiAppController::class, 'getByCourse']);

    Route::get('/uf', function () {
        $uf = State::all();
        return response()->json(['uf' => $uf], Response::HTTP_OK);
    });

    Route::get('/uf/{id}', function ($id) {
        $uf = State::find($id);
        return response()->json(['uf' => $uf], Response::HTTP_OK);
    });

    Route::get('/uf/{abbr?}/city', function ($abbr = null) {
        if (is_null($abbr)) {
            return response()->json(['error' => 'State abbreviation is required'], Response::HTTP_BAD_REQUEST);
        }

        $uf = State::where('abbr', $abbr)->first();

        if ($uf) {
            return response()->json(['cities' => $uf->city], Response::HTTP_OK);
        } else {
            return response()->json(['error' => 'State not found'], Response::HTTP_NOT_FOUND);
        }
    });

    Route::get('/city/{id}', function ($id) {
        $uf = City::find($id);
        return response()->json(['uf' => $uf], Response::HTTP_OK);
    });


    Route::get('/asaas/{cpf}', [OldAsaasController::class, 'list_pay']);
    Route::post('/asaas/link', [OldAsaasController::class, 'check_client_data']);
    Route::post('/asaas/link/client/create', [OldAsaasController::class, 'client_create']);
    Route::post('/asaas/link/pay/create', [OldAsaasController::class, 'client_pay_create']);

    //Route::get('/asaas/link/client/{id}/notification', [OldAsaasController::class, 'client_notification_api']);
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
