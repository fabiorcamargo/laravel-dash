<?php

namespace App\Http\Controllers;

use App\Models\CademiCourse;
use App\Models\UserApp;
use Illuminate\Http\Request;

class ApiAppController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $user = $request->user();

        // Verifica se já existe um UserApp com o mesmo fcm_token
        $userApp = $user->UserApp()->where('fcm_token', $request->fcm_token)->first();

        if ($userApp) {
            // Atualiza o registro existente
            $userApp->update([
                'uid' => $request->uid,
            ]);
        } else {
            // Cria um novo registro
            $user->UserApp()->create([
                'uid' => $request->uid,
                'fcm_token' => $request->fcm_token
            ]);
        }

        return response()->json([], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\UserApp  $userApp
     * @return \Illuminate\Http\Response
     */
    public function show(UserApp $userApp)
    {
        dd($userApp);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\UserApp  $userApp
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, UserApp $userApp)
    {
        dd($request->all(), $userApp);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\UserApp  $userApp
     * @return \Illuminate\Http\Response
     */
    public function destroy(UserApp $userApp)
    {
        //
    }

    public function getByCourse($course)
    {
        // Carrega os cursos com o nome especificado
        $courses = CademiCourse::where('course_name', $course)->get();

        $fcmTokens = []; // Inicializa um array para armazenar os tokens

        // Itera sobre cada curso para coletar os tokens FCM
        foreach ($courses as $course) {
            // Verifica se há um usuário associado ao curso
            if ($course->getUser && $course->getUser->userApp) {
                // Itera sobre cada UserApp relacionado ao usuário
                foreach ($course->getUser->userApp as $userApp) {
                    // Adiciona cada par de uid e fcm_token ao array como um objeto
                    $fcmTokens[] = [
                        'uid' => $userApp->uid,
                        'fcm_token' => $userApp->fcm_token,
                    ];
                }
            }
        }

        // Retorna todos os pares uid e fcm_token encontrados como um array JSON
        return response()->json($fcmTokens, 200);
    }
}
