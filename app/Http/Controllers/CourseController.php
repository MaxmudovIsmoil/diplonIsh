<?php

namespace App\Http\Controllers;

use App\Models\Content;
use App\Models\Course;
use App\Models\Plan;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CourseController extends Controller
{
    public function index(?int $courseId = null)
    {
        try {
            $plans = Plan::where('course_id', $courseId)
                ->get()
                ->toArray();

            return view('course.index', compact('plans', 'courseId'));
        }
        catch (\Exception $e) {
            $error = $e->getMessage();
            return view('course.index', compact('error'));
        }
    }

    public function getContent(int $courseId, int $planId): View
    {
        try {
            $plans = Plan::where('course_id', $courseId)
                ->get()
                ->toArray();
            $contents = Content::where('plan_id', $planId)
                ->get()
                ->toArray();

            return view('course.index', compact('plans', 'courseId', 'contents'));
        }
        catch (\Exception $e) {
            $error = $e->getMessage();
            return view('course.index', compact('error'));
        }
    }
}
