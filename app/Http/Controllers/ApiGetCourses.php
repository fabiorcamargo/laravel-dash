<?php

namespace App\Http\Controllers;

use App\Models\CademiCourse;
use App\Models\CademiListCourse;
use Illuminate\Http\Request;

class ApiGetCourses extends Controller
{


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getCademiCourses(Request $request)
    {
        $user = $request->user();

        $cademi = $user->cademis;
        $courses = $user->cademicourses;
        $TagCourses = [];

        if ($cademi) {
            foreach ($courses as $course) {
                foreach ($course->cademiTag as $tag) {
                    $TagCourses[] = $tag;
                }
            }
        }


        return response()->json(['courses' => $TagCourses, 'cademis' => $cademi]);
    }

    public function getCademiCoursesList(Request $request)
    {
        $user = $request->user();

        if($user->role == 4){

            $cademiCourses = CademiListCourse::all('name');

        }

        return response()->json(['courses' => $cademiCourses]);
    }
}
