<?php

namespace App\Http\Controllers;

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
        $user = ($request->user());
        $user->UserApp()->create([
            'uid' => $request->uid,
            'fcm_token' => $request->fcm_token
        ]);

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
}
