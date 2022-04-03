<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\APIResource;
use App\Models\Category;
use App\Models\CompleteCategory;
use App\Models\Course;
use App\Models\Score;
use App\Models\SubCategory;
use App\Models\UserCourse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class UserCourseController extends Controller
{
    public function storeAnswer(Request $request)
    {
        $table = UserCourse::where('course_id', $request->course_id)->first();
        $table->id = Str::random(10);
        $table->answer = $request->answer;
        $table->checked = true;
        if (Str::lower($request->course_text) == Str::lower($request->answer)) {
            $table->is_true = true;
        } else {
            $table->is_true = false;
        }
        $table->course_id = $request->course_id;
        $table->sub_category_id = $request->sub_category_id;
        $table->user_id = Auth::user()->id;
        if ($table->save()) {
            return response()->json([
                'success' => true,
            ], 200);
        }
    }

    public function getScore(Request $request)
    {
        $is_true = DB::table('user_courses')
            ->where('user_id', '=', Auth::user()->id)
            ->where('is_true', '=', true)
            ->where('sub_category_id', '=', $request->sub_category_id)->count();
        $total_test = DB::table('user_courses')
            ->where('user_id', '=', Auth::user()->id)
            ->where('sub_category_id', '=', $request->sub_category_id)->count();

        $sub = SubCategory::find($request->sub_category_id);
        $category = Category::find($sub->category_id);

        $total_sub = SubCategory::where('category_id', $category->id)->count();
        $data_sub = SubCategory::where('category_id', $category->id)->get();

        $total_complete = 0;

        foreach ($data_sub as $ds) {
            $course_checked = UserCourse::where('user_id', Auth::user()->id)
                ->where('sub_category_id', '=', $ds->id)
                ->where('checked', true)
                ->count();
            $total_course = UserCourse::where('user_id', Auth::user()->id)
                ->where('sub_category_id', '=', $ds->id)
                ->count();
            if ($total_course == $course_checked) {
                $total_complete++;
            }
        }

        if ($total_complete == $total_sub) {
            $table = CompleteCategory::where('category_id', $sub->category_id)->first();
            $table->is_complete = true;
            $table->save();
        }

        return response()->json([
            'is_true' => $is_true,
            'total_test' => $total_test,
            'success' => true,
        ], 200);
    }

    public function reloadTest(Request $request)
    {
        $table = UserCourse::where('sub_category_id', '=', $request->sub_category_id)
            ->where('user_id', '=', Auth::user()->id)
            ->delete();
        $is_true = DB::table('user_courses')
            ->where('user_id', '=', Auth::user()->id)
            ->where('is_true', '=', true)
            ->where('sub_category_id', '=', $request->sub_category_id)->count();
        $total_test = DB::table('user_courses')
            ->where('user_id', '=', Auth::user()->id)
            ->where('sub_category_id', '=', $request->sub_category_id)->count();
        $table_score = new Score();
        $table_score->id = Str::random(10);
        $table_score->score = $is_true . " / " . $total_test;
        $table_score->user_id = Auth::user()->id;
        $table_score->sub_category_id = $request->sub_category_id;
        $table_score->save();
        if ($table) {
            return response()->json([
                'deleted success' => true,
            ], 200);
        }
    }

    public function getTest(Request $request)
    {
        $total_test = DB::table('user_courses')
            ->where('user_id', '=', Auth::user()->id)
            ->where('sub_category_id', '=', $request->sub_category_id)->count();
        if ($total_test) {
            return response()->json([
                'complete' => true,
            ], 200);
        } else {
            return response()->json([
                'complete' => false,
            ], 200);
        }
    }

    public function getFinishCourses()
    {
        $data = CompleteCategory::where('user_id', Auth::user()->id)->get();
        return response()->json(['data' => $data]);
    }

    public function getIncompleteCourses()
    {
        $data = DB::table('user_courses')
            ->leftJoin('sub_categories', 'user_courses.sub_category_id', '=', 'sub_categories.id')
            ->leftJoin('categories', 'sub_categories.category_id', '=', 'categories.id')
            ->selectRaw("user_courses.id as id, categories.name as category_name, categories.image as category_image, sub_categories.name as sub_name, sub_category_id, count(checked or null) as complete, count(checked) as total, sub_categories.image as sub_image")
            ->where('user_id', Auth::user()->id)
            ->havingRaw('count(checked or null) < count(checked)')
            ->havingRaw('count(checked or null) > 0')
            ->groupBy('sub_category_id')
            ->get();
        return response()->json(['data' => $data]);
    }

    public function checkIncompleteCourse(Request $request)
    {
        $data = DB::table('user_courses')
            ->leftJoin('sub_categories', 'user_courses.sub_category_id', '=', 'sub_categories.id')
            ->leftJoin('categories', 'sub_categories.category_id', '=', 'categories.id')
            ->selectRaw("user_courses.id as id, categories.name as category_name, categories.image as category_image, sub_categories.name as sub_name, sub_category_id, count(checked or null) as complete, count(checked) as total, sub_categories.image as sub_image")
            ->where('user_id', Auth::user()->id)
            ->where('sub_category_id', $request->sub_category_id)
            ->groupBy('sub_category_id')
            ->get();
        return response()->json(['data' => $data]);
    }
}
