<?php

namespace App\Http\Controllers;

use App\Models\OuroClient;
use Illuminate\Http\Request;

class ApiGetOuroCourses extends Controller
{
    public function getOuroCourses(Request $request)
    {
        $user = $request->user();
        $ouro = $user->client_ouro->first();

        return response()->json(['ouroClient' => $ouro]);
    }
}
