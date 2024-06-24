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

        $OuroCourses = [];

        if ($user->client_ouro->first()) {
            $courses = $user->client_ouro->first()->matricula_ouro;
            foreach ($courses as $course) {
                if ($course->get_course) {
                    $OuroCourses[] = $course->get_course;
                }
            }
        }


        return response()->json(['ouroClient' => $ouro]);
    }
}
