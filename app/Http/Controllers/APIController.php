<?php

namespace App\Http\Controllers;

use App\Helpers\GDrive;
use App\Models\Category;
use App\Models\CompleteCategory;
use App\Models\Course;
use App\Models\Level;
use App\Models\SubCategory;
use App\Models\User;
use App\Models\UserCourse;
use App\Models\UserLevel;
use App\Models\UserSession;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class APIController extends Controller
{
    public function getAllChapter()
    {
        $data = Category::orderBy('level', 'asc')->get();
        return response()->json(['data' => $data], 200,[],JSON_NUMERIC_CHECK);
    }

    public function getCategoryById(Request $request)
    {
        $data = Category::find($request->id);
        return response()->json(['data' => $data], 200,[],JSON_NUMERIC_CHECK);
    }

    public function updateCategory(Request $request)
    {
        $table = Category::find($request->category_id);
        $table->name = $request->name;
        if (!empty($request->image)) {
            $image = $request->file('image');
            $file = $image->getContent();
            $filename = $image->getClientOriginalName();
            $filename = Str::random(16) . $filename;
            Storage::disk('google')->put($filename, $file);
            $listContents = Storage::disk('google')->listContents();
            $drive = new GDrive();
            $id = $drive->getDrivePath($listContents, 'name', $filename);
            $table->image = "https://drive.google.com/uc?id=" . $id['path'] . "&export=media";
        } else {
            $table->image = $table->image;
        }
        $table->level = $table->level;
        if ($table->save()) {
            return response()->json($table, 200,[],JSON_NUMERIC_CHECK);
            // return redirect()->route('categories.index')
            //     ->with('success', 'Category created successfully.');
        }
    }

    public function updateMateri(Request $request)
    {
        $table = SubCategory::find($request->id_materi_edit);
        $table->name = $request->name;
        $table->category_id = $request->category_id;

        if ($table->save()) {
            return response()->json(['data' => $table], 200,[],JSON_NUMERIC_CHECK);
        }
    }

    public function getAllMateri()
    {
        $data = SubCategory::all();
        return response()->json(['data' => $data], 200,[],JSON_NUMERIC_CHECK);
    }

    public function updateSoal(Request $request)
    {
        $table = Course::find($request->id_course);
        $table->indonesia_text = $request->indonesia_text;
        $table->english_text = $request->english_text;
        $table->sub_category_id = $request->sub_category_id;
        if (!empty($request->image)) {
            $image = $request->file('image');
            $file = $image->getContent();
            $filename = $image->getClientOriginalName();
            $filename = Str::random(16) . $filename;
            Storage::disk('google')->put($filename, $file);
            $listContents = Storage::disk('google')->listContents();
            $drive = new GDrive();
            $id = $drive->getDrivePath($listContents, 'name', $filename);
            $table->image = "https://drive.google.com/uc?id=" . $id['path'] . "&export=media";
        } else {
            $table->image = $table->image;
        }
        if ($request->file('image_course')) {
            $image_course = $request->file('image_course');
            $file_image_course = $image_course->getContent();
            $filename_image_course = $image_course->getClientOriginalName();
            $filename_image_course = Str::random(16) . $filename_image_course;
            Storage::disk('google')->put($filename_image_course, $file_image_course);
            $listContents_image_course = Storage::disk('google')->listContents();
            $drive_image_course = new GDrive();
            $id_image_course = $drive_image_course->getDrivePath($listContents_image_course, 'name', $filename_image_course);
            $table->image_course = "https://drive.google.com/uc?id=" . $id_image_course['path'] . "&export=media";
        } else {
            $table->image_course = $table->image_course;
        }
        if ($request->is_voice == 'true') {
            $table->is_voice = true;
        } else {
            $table->is_voice = false;
        }
        if ($table->save()) {
            return response()->json(['data' => $table], 200,[],JSON_NUMERIC_CHECK);
        }
    }

    public function updateUser(Request $request)
    {
        $table = User::find($request->id);
        $table->email = $request->email;
        $table->name = $request->name;
        if ($request->password) {
            $table->password = Hash::make($request->password);
        } else {
            $table->password = $table->password;
        }
        if ($table->save()) {
            return response()->json(['data' => $table], 200,[],JSON_NUMERIC_CHECK);
        }
    }

    public function userStatistic(Request $request)
    {
        $user_id = $request->user_id;
        $user_level = UserLevel::leftJoin('users', 'user_levels.user_id', '=', 'users.id')
            ->leftJoin('levels', 'user_levels.level_id', '=', 'levels.id')
            ->select('user_levels.user_id as user_id', 'levels.name as name', 'levels.point as point')
            ->where('user_levels.user_id', $user_id)
            ->first();
        $user_level_name = $user_level->name;
        $next_level = Level::where('point', '>', $user_level->point)
            ->orderBy('point', 'asc')
            ->first();

        $user_point = UserCourse::where('user_id', $user_id)
            ->where('is_true', true)
            ->count();
        $next_level_point = 0;
        $sisa_point = 0;
        $percent = 0;
        if ($next_level == null) {
            $next_level_point = 0;
            $sisa_point = 0;
            $percent = 100;
        } else {
            $next_level_point = $next_level->point;
            $sisa_point = $next_level_point - $user_point;
            $percent =  $next_level_point == 0 ? number_format(round($user_point) * 10, 0) : number_format(round(($user_point / $next_level_point) * 10) * 10, 0);
        }



        // Chapter Card
        $chapter_complete = CompleteCategory::where('user_id', $user_id)
            ->where('is_complete', true)
            ->count();
        if ($chapter_complete == null) {
            $chapter_complete = 0;
        }

        $chapter_count = Category::all()->count();
        $chapter_incomplete = $chapter_count - $chapter_complete;
        // Chapter Card

        // Materi Card
        $materi_complete = UserCourse::leftJoin('sub_categories', 'user_courses.sub_category_id', '=', 'sub_categories.id')
            ->select('user_courses.sub_category_id as sub_category_id', 'user_courses.checked as checked', 'user_courses.user_id as user_id', 'user_courses.is_true as is_true')
            ->where('user_id', $user_id)
            ->where('checked', true)
            ->groupBy('sub_category_id')
            ->get()
            ->count();
        $materi = SubCategory::all()->count();
        $materi_incomplete = $materi - $materi_complete;
        // Materi Card

        // Benar

        $materi_dikuasai = UserCourse::leftJoin('sub_categories', 'user_courses.sub_category_id', '=', 'sub_categories.id')
            ->select('user_courses.sub_category_id as sub_category_id', 'user_courses.checked as checked', 'user_courses.user_id as user_id', 'user_courses.is_true as is_true', 'sub_categories.name as name', DB::raw('COUNT(user_courses.is_true) as total_true'))
            ->where('user_id', $user_id)
            ->where('is_true', true)
            ->groupBy('sub_category_id')
            ->orderBy('total_true', 'desc')
            ->first();
        if ($materi_dikuasai == null) {
            $nama_materi_dikuasai = "Belum ada";
            $jumlah_benar = 0;
        } else {
            $nama_materi_dikuasai = $materi_dikuasai->name;
            $jumlah_benar = $materi_dikuasai->total_true;
        }
        // Benar

        // Salah

        $materi_tidak_dikuasai = UserCourse::leftJoin('sub_categories', 'user_courses.sub_category_id', '=', 'sub_categories.id')
            ->select('user_courses.sub_category_id as sub_category_id', 'user_courses.checked as checked', 'user_courses.user_id as user_id', 'user_courses.is_true as is_true', 'sub_categories.name as name', DB::raw('COUNT(user_courses.is_true) as total_false'))
            ->where('user_id', $user_id)
            ->where('is_true', false)
            ->where('checked', true)
            ->groupBy('sub_category_id')
            ->orderBy('total_false', 'desc')
            ->first();

        if ($materi_tidak_dikuasai == null) {
            $nama_materi_tidak_dikuasai = "Belum ada";
            $jumlah_salah = 0;
        } else {
            $nama_materi_tidak_dikuasai = $materi_tidak_dikuasai->name;
            $jumlah_salah = $materi_tidak_dikuasai->total_false;
        }
        // Salah

        $data = array(
            [
                'user_level_name' => $user_level_name,
                'user_point' => $user_point,
                'sisa_point' => $sisa_point,
                'percent' => $percent,
                'chapter_complete' => $chapter_complete,
                'chapter_incomplete' => $chapter_incomplete,
                'materi_complete' => $materi_complete,
                'materi_incomplete' => $materi_incomplete,
                'jumlah_benar' => $jumlah_benar,
                'nama_materi_dikuasai' => $nama_materi_dikuasai,
                'jumlah_salah' => $jumlah_salah,
                'nama_materi_tidak_dikuasai' => $nama_materi_tidak_dikuasai,
            ]
        );
        return response()->json(['data' => $data], 200,[],JSON_NUMERIC_CHECK);
    }

    public function chart(Request $request)
    {
        $data = UserSession::select(DB::raw("COUNT(*) as count"), 'created_at', 'user_id', DB::raw("DAY(created_at) as day"), DB::raw('WEEKDAY(created_at) as week_day'))->where('user_id', $request->user_id)->groupBy(DB::raw('DAY(created_at)'))->get()->groupBy(function ($date) {
            $created_at = Carbon::parse($date->created_at);
            $start = $created_at->startOfWeek()->format('d-m-Y');
            $end = $created_at->endOfWeek()->format('d-m-Y');
            return "{$start} - {$end}";
        });

        $materi = UserCourse::select(DB::raw("COUNT(*) as count"), 'created_at', 'user_id', 'sub_category_id', DB::raw("DAY(created_at) as day"), DB::raw('WEEKDAY(created_at) as week_day'))->where('user_id', $request->user_id)->where('checked', true)->groupBy(DB::raw('DAY(created_at)'))->get()->groupBy(function ($date) {
            $created_at = Carbon::parse($date->created_at);
            $start = $created_at->startOfWeek()->format('d-m-Y');
            $end = $created_at->endOfWeek()->format('d-m-Y');
            return "{$start} - {$end}";
        });

        return response()->json(['data' => $data, 'materi' => $materi], 200,[],JSON_NUMERIC_CHECK);
    }

    public function allChartData(Request $request)
    {
        $data = UserSession::select(DB::raw("COUNT(*) as count"), 'created_at', 'user_id', DB::raw("DAY(created_at) as day"), DB::raw('WEEKDAY(created_at) as week_day'))->groupBy(DB::raw('DAY(created_at)'))->orderBy('created_at','ASC')->get()->groupBy(function ($date) {
            $created_at = Carbon::parse($date->created_at);
            $start = $created_at->startOfWeek()->format('d-m-Y');
            $end = $created_at->endOfWeek()->format('d-m-Y');
            return "{$start} - {$end}";
        });

        $materi = UserCourse::select(DB::raw("COUNT(*) as count"), 'created_at', 'user_id', 'sub_category_id', DB::raw("DAY(created_at) as day"), DB::raw('WEEKDAY(created_at) as week_day'))->where('checked', true)->groupBy(DB::raw('DAY(created_at)'))->orderBy('created_at','ASC')->get()->groupBy(function ($date) {
            $created_at = Carbon::parse($date->created_at);
            $start = $created_at->startOfWeek()->format('d-m-Y');
            $end = $created_at->endOfWeek()->format('d-m-Y');
            return "{$start} - {$end}";
        });

        return response()->json(['data' => $data, 'materi' => $materi], 200,[],JSON_NUMERIC_CHECK);
    }

    public function getCardOnlineOfflineUser()
    {
        $users = User::where('role', 'student')->get();
        $online = 0;
        $offline = 0;
        foreach ($users as $user) {
            if (Cache::has('is_online' . $user->id)) {
                $online++;
            } else {
                $offline++;
            }
        }

        return response()->json(['user_online' => $online, 'user_offline' => $offline], 200);
    }

    public function getUserActivity()
    {
        $users = User::where('role', 'student')->orderBy('last_seen', 'DESC')->take(4)->get();
        $user_1 = '';
        $user_2 = '';
        $user_3 = '';
        $user_4 = '';
        foreach ($users as $key => $user) {
            if (Cache::has('is_online' . $user->id)) {
                if ($key == 0) {
                    $user_1 = 'Online';
                } else if ($key == 1) {
                    $user_2 = 'Online';
                } else if ($key == 2) {
                    $user_3 = 'Online';
                } else {
                    $user_4 = 'Online';
                }
            } else {
                if ($key == 0) {
                    $user_1 = $user->last_seen == null ? '-' : Carbon::parse($user->last_seen)->diffForHumans();
                } else if ($key == 1) {
                    $user_2 = $user->last_seen == null ? '-' : Carbon::parse($user->last_seen)->diffForHumans();
                } else if ($key == 2) {
                    $user_3 = $user->last_seen == null ? '-' : Carbon::parse($user->last_seen)->diffForHumans();
                } else {
                    $user_4 = $user->last_seen == null ? '-' : Carbon::parse($user->last_seen)->diffForHumans();
                }
            }
        }

        return response()->json(['data' => $users, 'user_1' => $user_1, 'user_2' => $user_2, 'user_3' => $user_3, 'user_4' => $user_4], 200,[],JSON_NUMERIC_CHECK);
    }
    
    public function sendEmail(Request $request){
         $details = [
            'title' => 'Title',
            'body' => 'Body'
        ];
       
        \Mail::to($request->email)->send(new \App\Mail\SendMail($details));
        
        return response()->json(['message'=>'Success'], 200);
    }
}
