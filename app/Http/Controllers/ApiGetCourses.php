<?php

namespace App\Http\Controllers;

use App\Models\CademiCourse;
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
        $courses = $user->cademicourses;
        $TagCourses = [];

        foreach ($courses as $course) {
            foreach ($course->cademiTag as $tag) {
                $TagCourses[] = $tag;
            }
        }

        return response()->json(['courses' => $TagCourses]);
    }
}
