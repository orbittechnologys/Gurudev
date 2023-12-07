<?php

namespace App\Http\Controllers;

use App\Models\Announcement;
use App\Models\Chapter;
use App\Models\Course;
use App\Models\CurrentAffair;
use App\Models\Material;
use App\Models\PaymentDetail;
use App\Models\Quiz;
use App\Models\SpecialTestCourse;
use App\Models\Subject;

use App\Models\User;
use App\Models\UserQuizDetail;
use App\Models\UserQuizQuestionDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App;
use App\Models\QuizDetail;
use App\Models\QuizInstruction;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use App\Models\WeeklyBuzz;
use App\Models\YoutubeVideo;
use App\Models\SpecialTestSubCourse;
use File;
use App\Models\WeeklyBuzzFolder;
use Illuminate\Support\Facades\Cache;

class UserController extends Controller
{


    public function userDashboard(Request $request)
    {
        $userId = Auth::id();
        //phpinfo();
       // $profileCount['course'] = Cache::rememberForever('courseCount'.$userId, function () use ($userId) {
        $profileCount['course'] = PaymentDetail::where('type_id', '<>', 0)
                ->where(['type' => 'Course', 'user_id' => $userId, 'status' => 'Success'])
                ->count();
       // });
        //$quizCount = Cache::rememberForever('quizCount'.$userId, function () use ($userId) {
            $quizCount= UserQuizDetail::join('quizzes', 'quizzes.id', 'user_quiz_details.quiz_id')
                ->where('type', '<>', 0)
                ->where(['user_id' => $userId])
                ->select(DB::raw('count(user_id) as quizCount'), 'type')
                ->groupBy('type')
                ->orderBY('type')
                ->get();
        //});
        $profileCount['mcq'] = $quizCount[0]['quizCount'];
        $profileCount['mockTest'] = $quizCount[1]['quizCount'] + $quizCount[2]['quizCount'] + $quizCount[3]['quizCount'];

        
        $bannerImages = Cache::rememberForever('BannerImages', function () {
            return App\Models\BannerImages::where(['type' => 'web'])            
                ->select('image', 'url')
                ->orderBy('id', 'DESC')->take(4)->get()->toArray();
        });
        $currentAffairs = Cache::rememberForever('CurrentAffair', function () {
            return CurrentAffair::orderBy('id', 'DESC')
                ->select('image', 'slug', 'date', 'title', 'description')
                ->orderBy('id', 'DESC')
                ->take(4)->get();
        });
        $mcq = Cache::rememberForever('mcqQuiz', function () {
            return Quiz::where(['type' => 1, 'status' => 'Active'])
                ->where('publish_date', '<=', date('Y-m-d'))
                ->orderBy('id', 'DESC')->take(4)->get();
        });
        $videoMaterials = Cache::rememberForever('Material', function () {
            return  Material::where(['type' => 'Video', 'for_dashboard' => 1])
                ->select('youtube_url', 'title')
                ->orderBy('id', 'DESC')
                ->take(4)->get();
        });
        $course =  Cache::rememberForever('Course', function () {
            return Course::where('status', 'Active')
                ->orderBy('id', 'DESC')
                ->select('background_image', 'slug', 'course')
                ->take(4)->get();
        });
        $Announcement=Cache::rememberForever('Announcement', function()
        {  $news=Announcement::orderBy('id', 'DESC')->take(6)->get();
          return $news;
        });

        return view('User/userDashboard')
            ->with([
                'profileCount' => $profileCount,'Announcement'=>$Announcement, 'course' => $course, 'mcq' => $mcq,  'videoMaterials' => $videoMaterials, 'currentAffairs' => $currentAffairs, 'bannerImages' => $bannerImages
            ]);
    }
    public function updateProfile(Request $request)
    {
        if ($request->isMethod('post')) {
            $user = User::where('id', '!=', Auth::user()->id)->where(function ($q) use ($request) {
                $q->where('mobile', $request->mobile);
                $q->orWhere('email', $request->email);
            })->first();
            if ($user) {
                if ($user->mobile == $request->mobile) $errors['mobile'] = 'Mobile No Already exist';
                if ($user->email == $request->email) $errors['email'] = 'Email  Already exist';
                return Redirect::back()
                    ->withErrors($errors)
                    ->withInput($request->input());
            }
            $file = $request->file('new_profile');
            if ($file != '' && $file->getClientOriginalName() != '') {
                /*--------------------- Remove Old image when comes to Edit -----------------------*/
                if (($request->input('id') != '') && ($file->getClientOriginalName() != '')) {
                    @unlink(public_path() . '/' . $request['profile']);
                }
                $newFileName = substr(trim($request->input('title')), 0, 8);
                $newFileName = $this->fileUpload('Uploads/User', $file, $newFileName);
                $request['profile'] = $newFileName;
            }
            $res = User::where('id', Auth::user()->id)->update($request->except(['_token', 'new_profile']));
            if ($res)
                return redirect('dashboard')->with('sweet-success', 'Profile Updated Successfully');
            return redirect('dashboard')->with('sweet-danger', 'Please Try After sometime');
        }
        $model = User::where('id', Auth::user()->id)->first();
        return view('User/updateProfile')
            ->with('model', $model);
    }

    public function announcements(Request $request)
    {
        $searchString = $request->searchString;
        $Announcement = Announcement::where(function ($q) use ($searchString) {
            if ($searchString != '') {
                $q->where('title', 'like', '%' . $searchString . '%');
                $date = date('Y-m-d', strtotime($searchString));
                if ($date != "1970-01-01")
                    $q->orWhere('date', $date);
            }
        })->orderBy('id', 'DESC')->paginate(9)->appends(request()->query());
        //dd($Announcement->total());
        return view('User/announcements')
            ->with(['announcement' => $Announcement]);
    }

    public function currentAffairs(Request $request)
    {
        $searchString = $request->searchString;
        $searchTag = $request->searchTag;


        $data = CurrentAffair::where(function ($q) use ($searchTag, $searchString) {
            if ($searchTag != '') {
                $q->where('tags', 'like', '%' . trim($searchTag) . '%');
            } else if ($searchString != '') {
                $q->where('slug', 'like', '%' . $searchString . '%');
                $q->orWhere('title', 'like', '%' . $searchString . '%');
                $q->orWhere('tags', 'like', '%' . trim($searchString) . '%');
                $date = date('Y-m-d', strtotime($searchString));
                if ($date != "1970-01-01")
                    $q->orWhere('date', $date);
            }
        })->with(['bookmark' => function ($q) {
            $q->where('user_id', auth()->user()->id);
        }])->orderBy('current_affairs.id', 'DESC')->paginate(6)->appends(request()->query());

        if ($data->total() == 1) {

            $relatedNews = CurrentAffair::where(function ($q) use ($data) {
                foreach ($data[0]->tag_array as $tag) {
                    $q->orWhere('tags', 'like', '%' . trim($tag) . '%');
                }
            })->where('id', '!=', $data[0]->id)->orderBy('id', 'DESC')->take(10)->get()->toArray();
            $size = 10 - sizeof($relatedNews);
            if ($size > 0) {
                $relatedNews1 = CurrentAffair::where('id', '!=', $data[0]->id)->orderBy('id', 'DESC')->take($size)->get()->toArray();
                $relatedNews = array_merge($relatedNews, $relatedNews1);
            }
            return view('User/currentAffairsDetail')
                ->with(['currentAffair' => $data[0], 'relatedNews' => $relatedNews]);
        }
        return view('User/currentAffairs')
            ->with(['current_affairs' => $data]);
    }

    public function course(Request $request)
    {
        $searchString = $request->searchString;
        $data = Course::with('payment')->where('status', 'Active')->orderBy('id', 'DESC')->get();
        //$this->saveJson($data, 'course');
        return view('User/course')
            ->with(['data' => $data]);
    }
    public function subject($slug)
    {

        $data = Subject::with(['chapterCount' => function ($q) {
            $q->where('status', 'Active')->where('date', '<=', date('Y-m-d'));
            $q->select(DB::raw('count(chapters.id) as chapterCount'), 'subject_id')->groupBy('subject_id');
        }, 'quizCount' => function ($q) {
            $q->select(DB::raw('count(quizzes.id) as quizCount'), 'status', 'publish_date', 'subject_id')->groupBy('subject_id');
            $q->where('status', 'Active')->where('publish_date', '<=', date('Y-m-d'));
        }])->wherehas('course', function ($q) use ($slug) {
            $q->where('slug', $slug);
        })->where('status', 'Active')->orderBy('id', 'DESC')->get();
        // dd($data->toArray());

        if ($data->count() == 0) {
            return Redirect::back()->with('sweet-warning', 'No Subjects for this Course');
        }
        return view('User/courseSubjects')
            ->with(['data' => $data]);
    }
    public function chapter($slug)
    {
        $userId = Auth::user()->id;
        $data = Chapter::with(['course', 'course.payment'])->wherehas('subject', function ($q) use ($slug) {
            $q->where('slug', $slug);
        })->where('date', '<=', date('Y-m-d'))
            ->where('status', 'Active')->orderBy('id', 'DESC')->get();
        //dd($data[0]->toArray());
        $this->saveJson($data, 'chapters');
        if ($data->count() == 0) {
            return Redirect::back()->with('sweet-warning', 'No Chapters for this Subject');
        }
        return view('User/courseSubjectsChapters')
            ->with(['data' => $data]);
    }
    public function material($slug)
    {
        $userId = Auth::user()->id;
        $data = Chapter::with(['course', 'subject', 'course.payment'])
            ->where('date', '<=', date('Y-m-d'))
            ->where('slug', $slug)
            ->where('status', 'Active')->first();
        $quiz = Quiz::with(['userQuizDetail' => function ($q) use ($userId) {
            $q->where('user_id', $userId);
        }])->whereHas('chapter', function ($q) use ($slug) {
            $q->where('slug', $slug);
        })->where('status', 'Active')->where('publish_date', '<=', date('Y-m-d'))->first();
        $instruction = QuizInstruction::where(['type' => 'Chapter'])
            ->first();

        // dd($quiz->toArray());

        //$this->saveJson( [['material' =>[$data],'quiz'=>[$quiz]]], 'materials');
        if ($data->course->payment != null || $data->type == 'Free') {
            return view('User/courseSubjectsChaptersMaterial')
                ->with(['data' => $data, 'quiz' => $quiz, 'instruction' => $instruction->instruction]);
        } else {
            return Redirect::back()->with('sweet-danger', 'Please Purchase this chapter to view material');
        }
    }

    public function mcq(Request $request)
    {
        $searchString = $request->searchString;
        $isSearch = ($searchString != '') ? true : false;
        $date = false;
        if ($searchString != '') {
            $searchString = date('Y-m-d', strtotime($searchString));
            if ($searchString != "1970-01-01") {
                $date = $searchString;
            }else{
                $searchString = $request->searchString;
            }
        }

        $userId = Auth::user()->id;
        $quiz = Quiz::with(['userQuizDetail' => function ($q) use ($userId) {
            $q->where('user_id', $userId);
        }])->where(['type' => 1, 'status' => 'Active'])
            ->where(function ($q) use ($date, $isSearch,$searchString) {
                if ($date) {
                    $q->where('publish_date', $date);
                } else if (!$isSearch) {
                    $q->whereRaw("publish_date BETWEEN ((select MAX(publish_date) from quizzes WHERE `type`=1 AND deleted_at IS NULL) - INTERVAL 30 DAY) AND (select MAX(publish_date) from quizzes where `type`=1 AND deleted_at IS NULL)");
                }else{
                    $q->where('quiz_name','LIKE','%'.$searchString.'%');
                }
            })

            ->orderBy('id', 'DESC')->get();
        //dd($quiz->toArray());
        $instruction = QuizInstruction::where(['type' => 'MCQ'])
            ->first();
        return view('User/mcq')
            ->with(['instruction' => $instruction->instruction, 'quiz' => $quiz, 'date' => date('d-m-Y', strtotime($date))]);
    }
    public function mcqTest($id)
    {
        $userId = Auth::user()->id;
        $quiz = Quiz::with(['quizDetail', 'quizDetail.question', 'userQuizDetail' => function ($q) use ($userId) {
            $q->where('user_id', $userId);
        }])->where(['status' => 'Active', 'id' => $id])->where('publish_date', '<=', date('Y-m-d'))->first();

        //dd($quiz->toArray());
        if ($quiz->userQuizDetail != null) {
            return redirect('key-answers/' . $quiz->userQuizDetail->id)->with('sweet-success', 'MCQ Already Completed');
        }

        $timeArr = explode(':', $quiz->total_time);
        $decTime = ($timeArr[0] * 60) + ($timeArr[1]) + ($timeArr[2] / 60);
        $quiz_end = date('Y-m-d H:i:s', strtotime('+' . $decTime . ' minutes', strtotime(date('Y-m-d H:i:s'))));
        return view('User/onlineTest')
            ->with(['questions' => $quiz->toArray(), 'quiz_end' => $quiz_end]);
    }


    public function onlineTest($id)
    {
        $userId = Auth::user()->id;
        $quiz = Quiz::with(['quizDetail', 'quizDetail.question', 'chapter', 'course', 'userQuizDetail' => function ($q) use ($userId) {
            $q->where('user_id', $userId);
        }])->where(['status' => 'Active', 'id' => $id])->where('publish_date', '<=', date('Y-m-d'))->first();

        //dd($quiz->toArray());
        if ($quiz->userQuizDetail != null) {
            return redirect('key-answers/' . $quiz->userQuizDetail->id)->with('sweet-success', 'Mock Test Already Completed');
        }
        if ($quiz->course->payment != null || $quiz->chapter->type == 'Free') {
            $timeArr = explode(':', $quiz->total_time);
            $decTime = ($timeArr[0] * 60) + ($timeArr[1]) + ($timeArr[2] / 60);
            $quiz_end = date('Y-m-d H:i:s', strtotime('+' . $decTime . ' minutes', strtotime(date('Y-m-d H:i:s'))));
            return view('User/onlineTest')
                ->with(['questions' => $quiz->toArray(), 'quiz_end' => $quiz_end]);
        } else {
            return Redirect::back()->with('sweet-danger', 'Please Purchase this chapter to view material');
        }
    }
    public function onlineTestSave(Request $request)
    {

        $table1 = new UserQuizDetail();
        $table2 = new UserQuizQuestionDetail();
        $data['user_id'] = Auth::user()->id;
        $data['quiz_id'] = $request->quiz_id;
        $data['total_time_taken'] = $request->total_time_taken;
        $data['total_question_attended'] = $request->total_question_attended;
        $data['correct_answer'] = $request->correct_answer;
        $data['negative_marks'] = $request->negative_marks;
        $data['total_marks'] = $request->total_marks;
        $data['obtained_marks'] = $request->obtained_marks;
        //dd($request->input());
        $retry = UserQuizDetail::where(['user_id' => $data['user_id'], 'quiz_id' => $data['quiz_id']])->select('id')->first();
        if (!empty($retry)) {
            $data['id'] = $retry['id'];
            UserQuizQuestionDetail::where(['user_quiz_detail_id' => $data['id']])->delete();
        }
        //dd($request->input());
        $data2 = [];
        $id = $table1->saveData($data);

        $second_table = json_decode($request->second_array);
        foreach ($second_table as $item) {
            if ($item[0]) {
                $temp_array['user_quiz_detail_id'] = $id;
                $temp_array['question_id'] = $item[0];
                $temp_array['given_answer'] = $item[1];
                $temp_array['created_at'] = date('Y-m-d H:i:s');

                array_push($data2, $temp_array);
            }
        }
        $res = $table2->saveData($data2);

        return Response()->json(array('result' => $res, 'id' => $id));
    }
    public function keyAnswers($id)
    {
        $userQuizDetail = new UserQuizDetail();
        $userId = Auth::user()->id;
        $keyAnswers = $userQuizDetail->where(['id' => $id, 'user_id' => $userId])
            ->with(['quiz', 'quiz.quizDetail', 'quiz.quizDetail.question', 'userQuizQuestionDetail'])
            ->first();
        if ($keyAnswers == null) {
            abort(403, 'Access denied');
        }
        //dd($keyAnswers);


        return view('User/keyAnswers')
            ->with([
                'types' => $this->getTypes(),
                'key_answers' => $keyAnswers->toArray(),

            ]);
    }


    public function studyMaterials(Request $request)
    {
        $searchString = $request->searchString;
        $searchTag = $request->searchTag;


        $data = Material::where('type', 'Study')->where(function ($q) use ($searchTag, $searchString) {
            if ($searchTag != '') {
                $q->where('tags', 'like', '%' . trim($searchTag) . '%');
            } else if ($searchString != '') {

                $q->orWhere('title', 'like', '%' . $searchString . '%');
                $q->orWhere('tags', 'like', '%' . trim($searchString) . '%');
                $date = date('Y-m-d', strtotime($searchString));
                if ($date != "1970-01-01")
                    $q->orWhere('date', $date);
            }
        })->orderBy('id', 'DESC')->paginate(6)->appends(request()->query());


        return view('User/studyMaterials')
            ->with(['data' => $data]);
    }
    public function videoMaterials(Request $request)
    {
        $searchString = $request->searchString;
        $searchTag = $request->searchTag;

        $data = Material::where('type', 'Video')->where(function ($q) use ($searchTag, $searchString) {
            if ($searchTag != '') {
                $q->where('tags', 'like', '%' . trim($searchTag) . '%');
            } else if ($searchString != '') {

                $q->orWhere('title', 'like', '%' . $searchString . '%');
                $q->orWhere('tags', 'like', '%' . trim($searchString) . '%');
                $date = date('Y-m-d', strtotime($searchString));
                if ($date != "1970-01-01")
                    $q->orWhere('date', $date);
            }
        })->orderBy('id', 'DESC')->paginate(6)->appends(request()->query());
        return view('User/videoMaterials')
            ->with(['data' => $data]);
    }
    function saveJson($data, $name)
    {
        Storage::disk('public')->put($name . '.json', response()->json($data));
    }
    function liveClass(Request $request)
    {
        $userId = auth()->user()->id;
        $startTime = date('Y-m-d H:i', strtotime('-20 minutes'));
        $date = "'" . date('Y-m-d H:i') . "'";
        $tableList = App\Models\LiveClass::with('batch')
            ->where(function ($q) use ($startTime) {
                $q->where('start_time', '>=', $startTime)
                    ->orWhere('end_time', '>=', $startTime);
            })->whereHas('batch', function ($q) use ($userId) {
                $q->whereRaw("find_in_set($userId,user_id)");
            })->orderBy('start_time', 'ASC')
            ->select(
                'live_classes.*',
                DB::raw('(CASE WHEN live_classes.start_time >=' . $date . ' THEN "NOT_STARTED" ELSE "STARTED" END) AS class_status'),
                DB::raw("TIMEDIFF(start_time," . $date . ") AS Remaining_Minutes")
            )->get();

        // print_r($tableList->toArray());

        return view('User/liveClass')->with([
            'tableList' => $tableList
        ]);
    }
    function bookmark(Request $request)
    {
        if ($request->isMethod('post')) {
            $requestData = $request->all();
            $table = new App\Models\Bookmark();
            $res = $table->saveData($requestData);
            return Response()->json($res);
        }
    }
    function bookmarks(Request $request)
    {
        $searchString = $request->searchString;
        $searchTag = $request->searchTag;

        $data = CurrentAffair::where(function ($q) use ($searchTag, $searchString) {
            if ($searchTag != '') {
                $q->where('tags', 'like', '%' . trim($searchTag) . '%');
            } else if ($searchString != '') {
                $q->where('slug', 'like', '%' . $searchString . '%');
                $q->orWhere('title', 'like', '%' . $searchString . '%');
                $q->orWhere('tags', 'like', '%' . trim($searchString) . '%');
                $date = date('Y-m-d', strtotime($searchString));
                if ($date != "1970-01-01")
                    $q->orWhere('date', $date);
            }
        })->join('bookmarks', function ($join) {
            $join->on('type_id', 'current_affairs.id')
                ->where(['user_id' => auth()->user()->id, 'type' => 'CurrentAffairs']);
        })->select('current_affairs.*', 'bookmarks.type_id')
            ->orderBy('current_affairs.id', 'DESC')->paginate(6)->appends(request()->query());

            
        if ($data->total() == 1) {

            $relatedNews = CurrentAffair::where(function ($q) use ($data) {
                foreach ($data[0]->tag_array as $tag) {
                    $q->orWhere('tags', 'like', '%' . trim($tag) . '%');
                }
            })->where('current_affairs.id', '!=', $data[0]->id)
                ->join('bookmarks', function ($join) {
                    $join->on('type_id', 'current_affairs.id')
                        ->where(['user_id' => auth()->user()->id, 'type' => 'CurrentAffairs']);
                })->select('current_affairs.*', 'bookmarks.type_id')
                ->orderBy('current_affairs.id', 'DESC')->take(10)->get();

            $size = 10 - sizeof($relatedNews);
            
            if ($size > 0) {
                $selectedIds = $relatedNews->pluck('id','id');
                $relatedNews1 = CurrentAffair::where('current_affairs.id', '!=', $data[0]->id)
                    ->join('bookmarks', function ($join) {
                        $join->on('type_id', 'current_affairs.id')
                            ->where(['user_id' => auth()->user()->id, 'type' => 'CurrentAffairs']);
                    })->whereNotIn('current_affairs.id',$selectedIds)
                    ->select('current_affairs.*', 'bookmarks.type_id')
                    ->orderBy('current_affairs.id', 'DESC')->take($size)->get()->toArray();

                $relatedNews = array_merge($relatedNews->toArray(), $relatedNews1);
            }
            
           
            return view('User/bookmarksDetail')
                ->with(['currentAffair' => $data[0], 'relatedNews' => $relatedNews]);
        }
        return view('User/bookmarks')
            ->with(['current_affairs' => $data]);
    }
    public function weeklyBuzzFolder(Request $request)
    {
        $searchString = $request->searchString;
        $data = WeeklyBuzzFolder::join('weekly_buzzs', 'weekly_buzz_folders.id', 'weekly_buzz_folder_id')
            ->selectRaw('count(*) AS count,weekly_buzz_folders.id,folder_name')
            ->where('weekly_buzzs.deleted_at', NULL)
            ->groupBy('weekly_buzz_folder_id')
            ->orderBy('weekly_buzz_folders.id', 'DESC')->paginate(20)->appends(request()->query());

        //dd($data->toArray());
        return view('User/weeklyBuzzFolder')
            ->with(['data' => $data]);
    }
    public function weeklyBuzz(Request $request)
    {
        $searchString = $request->searchString;
        $data = WeeklyBuzz::where(function ($q) use ($searchString) {
            if ($searchString != '') {

                $q->orWhere('title', 'like', '%' . $searchString . '%');
                $date = date('Y-m-d', strtotime($searchString));
                if ($date != "1970-01-01")
                    $q->orWhere('date', $date);
            }
        })->where('weekly_buzz_folder_id', $request->folder_id)
            ->orderBy('id', 'DESC')->paginate(6)->appends(request()->query());


        return view('User/weeklyBuzz')
            ->with(['data' => $data, 'folder_id' => $request->folder_id]);
    }
    public function studyMaterialView($slug)
    {
        $userId = Auth::user()->id;
        $data = Chapter::with(['course', 'subject', 'course.payment'])
            ->where('date', '<=', date('Y-m-d'))
            ->where('slug', $slug)
            ->where('status', 'Active')->first();
        //  dd(public_path($data->material));
        if ($data->course->payment != null || $data->type == 'Free') {
            $newfile = 'user/TempforView/' . rand(100, 999999) . '.pdf';
            File::copy(uploads($data->material), public_path($newfile));
            return view('User/studyMaterialView')->with('newfile', $newfile)->with('backurl', 'course/subject/chapter/' . $slug);
        } else {
            return Redirect::back()->with('sweet-danger', 'Please Purchase this chapter to view material');
        }
    }
    function deleteMaterial(Request $request)
    {
        File::delete(public_path($request->newfile));
    }
    public function youtubeVideos(Request $request)
    {
        $searchString = $request->searchString;
        $data = YoutubeVideo::where(function ($q) use ($searchString) {
            if ($searchString != '') {

                $q->orWhere('title', 'like', '%' . $searchString . '%');
                $date = date('Y-m-d', strtotime($searchString));
                if ($date != "1970-01-01")
                    $q->orWhere('date', $date);
            }
        })->orderBy('id', 'DESC')->paginate(6)->appends(request()->query());


        return view('User/youtubeVideos')
            ->with(['data' => $data]);
    }


    public function specialTestCourse()
    {
        $data = SpecialTestCourse::with(['payment', 'quizCount' => function ($q) {
            $q->select(DB::raw('count(quizzes.id) as quizCount'), 'status', 'publish_date', 'course_id')->groupBy('course_id');
            $q->where('status', 'Active');
        }])->orderBy('id', 'DESC')->get();
        //$this->saveJson( $data, 'SpecialTestCourse');
        return view('User/specialTestCourse')
            ->with(['data' => $data]);
    }
    public function  specialTestQuizList(Request $request)
    {
        $slug = $request->slug;
        $id = $request->id;
        $date = date('Y-m-d');

        $userId = Auth::user()->id;
        if ($request->courseType == 2) {
            $specialTestSubCourse = SpecialTestSubCourse::with(['course', 'payment', 'quizCount' => function ($q) {
                $q->select(DB::raw('count(quizzes.id) as quizCount'), 'status', 'publish_date', 'subject_id')->groupBy('subject_id');
            }])->whereHas('course', function ($q) use ($slug) {
                $q->where('slug', $slug);
            })->orderBy('id', 'DESC')->get();
            //dd($specialTestSubCourse->toArray());

            $quiz = Quiz::with(['specialCourse.payment', 'userQuizDetail' => function ($q) use ($userId) {
                $q->where('user_id', $userId);
            }])->whereHas('specialCourse', function ($q) use ($slug) {
                $q->where('slug', $slug);
            })->where(['type' => $request->courseType, 'status' => 'Active'])
                ->orderBy('id', 'DESC')->get();
        } else {
            $quiz = Quiz::with(['stSubCourse.payment', 'userQuizDetail' => function ($q) use ($userId) {
                $q->where('user_id', $userId);
            }])->whereHas('stSubCourse', function ($q) use ($id) {
                $q->where('id', $id);
            })
                ->where(['type' => $request->courseType, 'status' => 'Active'])
                ->orderBy('id', 'DESC')->get();
        }
        if ($quiz->count() == 0 && ($specialTestSubCourse == null || $specialTestSubCourse->count() == 0)) {
            return Redirect::back()->with('sweet-warning', 'No Test for this Course');
        }
        if ($quiz[0]->specialCourse->payment != null || $quiz[0]->specialCourse->type == 'Free' || $specialTestSubCourse != null) {
            $instruction = QuizInstruction::where(['type' => 'Special'])
                ->first();
            //  dd($quiz->toArray());
            return view('User/specialTestQuizList')
                ->with(['instruction' => $instruction->instruction, 'quiz' => $quiz, 'specialTestSubCourse' => $specialTestSubCourse]);
        } else {
            return Redirect::back()->with('sweet-danger', 'Please Purchase Course to view material');
        }
    }

    public function specialTest(Request $request, $id = null)
    {
        $table = new UserQuizDetail();
        $data = [
            'quiz_id' => $id, 'status' => 0, 'total_marks' => 0,
            'total_marks' => 0,
            'total_question_attended' => 0,
            'correct_answer' => 0,
            'user_id' => auth()->user()->id,
            'obtained_marks' => 0,
            'negative_marks' => 0,
            'total_time_taken' => "00:00:00"
        ];
        $request->session()->put('current_mok_test_id', $id);
        $request->session()->put('current_mok_test_status', 0);
        $exist = $table->where(["quiz_id" => $data["quiz_id"], "user_id" => $data["user_id"]])->first();
        if (is_null($exist)) {
            $quizCat = Quiz::select('questions_category_details')->where('id', $id)->first();
            $quizCat = json_decode($quizCat->questions_category_details, TRUE);
            $quizCat = array_map(function ($value) {
                return "00:00:00";
            }, $quizCat);
            $data['category_info'] = json_encode($quizCat);
            //dd($quizCat);
            $createdId = $table->create($data);
        }
        $this->user_id = auth()->user()->id;
        $mock_details = Quiz::with(['userQuizDetail' => function ($query) {
            $query->where('user_id', $this->user_id);
        }])->where('id', $id)->first()->toArray();
        if ($mock_details['user_quiz_detail'])
            $this->mock_id = $mock_details['user_quiz_detail']['id'];
        else
            $this->mock_id = 0;

        if ($quiz->user_quiz_detail['status'] == 1) {
            return Redirect::back()->with('sweet-success', 'SpecialTest Already Completed');
        }

        // $subject = QuizDetail::where('quiz_id',$id)->orderBy('question_id')->orderBy('category')->pluck('category','category')->toArray();
        // $subject_ids=array_keys($subject);
        // $subject_ids=implode(",",$subject_ids);
        $questions = QuizDetail::with(['question'])
            ->leftJoin('user_quiz_question_details', function ($join) {
                $join->on('user_quiz_question_details.question_id', 'quiz_details.question_id');
                $join->where('user_quiz_question_details.user_quiz_detail_id',  $this->mock_id);
            })->orderBy("quiz_details.category", "ASC")
            ->where('quiz_id', $mock_details['id'])
            ->orderBy('category')->orderBy('question_id')
            ->select([
                'user_quiz_question_details.id as umqd_id',
                'user_quiz_question_details.user_quiz_detail_id',
                'user_quiz_question_details.given_answer',
                'user_quiz_question_details.mark_review',
                'quiz_details.*',
            ])
            ->get()
            ->toArray();

        $count_array = [];
        $val = 1;
        $final_counter = [];

        $i = 0;
        $type_counter['answered'] = 0;
        $type_counter['not_answered'] = 0;
        $type_counter['not_visited'] = 0;
        $type_counter['marked_review'] = 0;
        $type_counter['answered_marked_review'] = 0;
        $subject_qu_counter = [];
        $subject_tot_count = [];
        $subject = [];
        $subjectTime = [];


        //dd($questions);
        $initialTimeforCat = [];
        foreach ($questions as $item) {
            $subject[$item['category']] = $item['category'];
            $subjectTime[$item['category']] = $item['category_time'];
            $initialTimeforCat[$item['category']] = "00:00:00";
            array_push($count_array, $item['category']);
            $givenAnswer = !empty(trim($item['given_answer']));
            $subject_tot_count[$item['category']]++;
            if ($item['umqd_id'] && $givenAnswer && $item['mark_review']) {
                $type_counter['answered_marked_review']++;
                $subject_qu_counter[$item['category']]['answered_marked_review']++;
                $questions[$i]['question_status'] = 'answered_mark_review_count';
            } else if ($item['umqd_id'] && $givenAnswer && !$item['mark_review']) {
                $type_counter['answered']++;
                $subject_qu_counter[$item['category']]['answered']++;
                $questions[$i]['question_status'] = 'answered_count';
            } else if ($item['umqd_id'] && !$givenAnswer && !$item['mark_review']) {
                $type_counter['not_answered']++;
                $subject_qu_counter[$item['category']]['not_answered']++;
                $questions[$i]['question_status'] = 'not_answered_count';
            } else if ($item['umqd_id'] && !$givenAnswer && $item['mark_review']) {
                $type_counter['marked_review']++;
                $subject_qu_counter[$item['category']]['marked_review']++;
                $questions[$i]['question_status'] = 'marked_review_count';
            } else {
                $type_counter['not_visited']++;
                $subject_qu_counter[$item['category']]['not_visited']++;
                $questions[$i]['question_status'] = '';
            }


            $i++;
        }


        //dd($mock_details['user_quiz_detail']);
        $count_val = array_count_values($count_array);
        foreach ($count_val as $count) {
            array_push($final_counter, $val);
            $val += $count;
        }
        //dd($mock_details['user_quiz_detail']['category_info']);
        return view('User/specialTest')->with([
            'mock_details' => $mock_details,
            'questions' => $questions,
            'subject' => $subject,
            'final_counter' => $final_counter,
            'type_counter' => $type_counter,
            'subjectTime' => $subjectTime,
            "subject_tot_count" => $subject_tot_count,
            'subject_qu_counter' => $subject_qu_counter
        ]);
    }

    public function check_test_status(Request $request)
    {
        return Response()->json(['status' => $request->session()->get('current_mok_test_status')]);
    }

    public function specialTestSave(Request $request)
    {

        if (auth()->user()->id == 0) {
            return Response()->json(['noSession' => 'noSession']);
        }


        $table = new UserQuizQuestionDetail();
        // $data['id']=$request->id;
        $quizInfo = UserQuizDetail::where('id', $request->user_mock_detail_id)->first();
        $category_info = json_decode($quizInfo->category_info, TRUE);
        if($request->activeCatSpendTime!=null)
            $category_info[$request->subject_id] = $request->activeCatSpendTime;
        //dd($category_info);

        $data['user_quiz_detail_id'] = ($request->user_mock_detail_id) ? $request->user_mock_detail_id : " ";
        $data['category'] = ($request->subject_id) ? $request->subject_id : " ";
        $data['question_id'] = ($request->question_id) ? $request->question_id : " ";
        $data['given_answer'] = $request->given_answer;
        $data['mark_review'] = ($request->mark_review) ? $request->mark_review : 0;
        $data['marks'] = $request->marks;
        $data['neg_marks'] = $request->neg_marks;
        $data['id'] = $request->id;

        if (!empty(trim($data['given_answer'])) && $data['mark_review']) {
            $data['status'] = 'answered-and-mark';
        } else if (!empty(trim($data['given_answer'])) && !$data['mark_review']) {
            $data['status'] = 'Answered';
        } else if (empty(trim($data['given_answer'])) && !$data['mark_review']) {
            $data['status'] = 'not-answered';
        } else if (empty(trim($data['given_answer'])) && $data['mark_review']) {
            $data['status'] = 'review';
        } else {
            $data['status'] = 'not-visited';
        }
        $this->user_mock_detail_id = $request->user_mock_detail_id;
        if ($data['user_quiz_detail_id'] != '' && $data['question_id'] != '' &&  $data['category'] != '') {
            $id = $table->saveMockData($data);

            UserQuizDetail::where('id', $request->user_mock_detail_id)
                ->update(['last_attended_id' => $id, 'category_info' => json_encode($category_info)]);
        }
        $subject_qu_counter['answered_marked_review'] = 0;
        $subject_qu_counter['answered'] = 0;
        $subject_qu_counter['not_answered'] = 0;
        $subject_qu_counter['marked_review'] = 0;
        $subject_qu_counter['not_visited'] = 0;
        $questions = QuizDetail::with(['question'])
            ->leftJoin('user_quiz_question_details', function ($join) {
                $join->on('user_quiz_question_details.question_id', 'quiz_details.question_id');
                $join->where('user_quiz_question_details.user_quiz_detail_id', $this->user_mock_detail_id);
            })
            ->where('quiz_id', $request->mock_test_id)
            ->where('quiz_details.category', $request->subject_id)
            ->orderBy('quiz_details.id', 'ASC')
            ->select([
                'user_quiz_question_details.id as umqd_id',
                'user_quiz_question_details.user_quiz_detail_id',
                'user_quiz_question_details.given_answer',
                'user_quiz_question_details.mark_review',
                'user_quiz_question_details.status',
                'quiz_details.*'
            ])
            ->get()
            ->toArray();
        foreach ($questions as $item) {
            $givenAnswer = !empty(trim($item['given_answer']));

            if ($item['status'] == 'answered-and-mark') {
                $subject_qu_counter['answered_marked_review']++;
            } else if ($item['status'] == 'Answered') {
                $subject_qu_counter['answered']++;
            } else if ($item['status'] == 'not-answered') {
                $subject_qu_counter['not_answered']++;
            } else if ($item['status'] == 'review') {
                $subject_qu_counter['marked_review']++;
            } else {
                $subject_qu_counter['not_visited']++;
            }
        }
        return Response()->json(['second_table_id' => $id, 'subject_qu_counter' => $subject_qu_counter]);
    }

    public function specialTestUpdate(Request $request)
    {

        $table = new UserQuizDetail();
        $quizInfo = UserQuizDetail::where('id', $request->id)->first();
        $category_info = json_decode($quizInfo->category_info, TRUE);
        if ($request->activeCatSpendTime != null)
            $category_info[$request->activeCat] = $request->activeCatSpendTime;
        //dd($category_info);
        $data = [

            'quiz_id' => $request->question_allocation_id,
            'status' => $request->status,
            'user_id' => auth()->user()->id,
            'total_time_taken' => $request->spend_time,
            'category_info' => json_encode($category_info)

        ];

        $res = $table->saveSpecialTestData($data);
        $qu_counter = [];
        $result = '';
        if ($request->status == 1) {

            $qu_counter['answered_marked_review'] = 0;
            $qu_counter['answered'] = 0;
            $qu_counter['not_answered'] = 0;
            $qu_counter['marked_review'] = 0;
            $qu_counter['not_visited'] = 0;

            $qu_counter['attended_question'] = 0;
            $qu_counter['right_answer'] = 0;
            $qu_counter['wrong_answer'] = 0;


            $result = UserQuizQuestionDetail::with(['question'])->where(['user_quiz_detail_id' => $request->id])->get()->toArray();
            //$result_2 = UserMockDetail::where(['id'=>$request->id])->get()->toArray();
            $quizTotalMarks = QuizDetail::where(['quiz_id' => $data['quiz_id']])
                ->join('questions AS Question', function ($question) {
                    $question->on('Question.id', '=', 'quiz_details.question_id');
                })->sum('marks');
            $quizTotalCount = QuizDetail::where(['quiz_id' => $data['quiz_id']])
                ->join('questions AS Question', function ($question) {
                    $question->on('Question.id', '=', 'quiz_details.question_id');
                })->count();

            //dd($result);
            $negetiveMarks = 0;
            $obtained_marks = 0;
            $negetiveCount = 0;
            $obtained_qu_marks = 0;
            foreach ($result as $item) {

                $qu_counter['attended_question']++;

                if ($item['status'] == 'answered-and-mark') {
                    $qu_counter['answered_marked_review']++;
                } else if ($item['status'] == 'Answered') {
                    $qu_counter['answered']++;
                } else if ($item['status'] == 'not-answered') {
                    $qu_counter['not_answered']++;
                } else if ($item['status'] == 'review') {
                    $qu_counter['marked_review']++;
                }

                if ($item['given_answer'] == $item['question']['correct_answer']) {
                    $qu_counter['right_answer']++;
                } else if (!empty($item['given_answer'])) {
                    $qu_counter['wrong_answer']++;
                }
                $obtained_marks += $item['marks'] - $item['neg_marks'];
                $obtained_qu_marks += $item['marks'];
                $negetiveMarks += $item['neg_marks'];
                if ($item['neg_marks'] > 0) $negetiveCount++;
            }
            $quizInfo = UserQuizDetail::where('id', $request->id)->first();
            $category_info = json_decode($quizInfo->category_info, TRUE);
            $totalSeconds=0;
            $date = '2007-05-14';
            $datetime = strtotime($date."00:00:00");
            foreach($category_info as $time){
                if($time!="00:00:00"){
                    $totalSeconds += strtotime("$date $time") - $datetime;
                }
            }
            $totalTimeTaken=str_pad(floor($totalSeconds / 3600),2,0,STR_PAD_LEFT).":".str_pad(floor(($totalSeconds / 60) % 60),2,0,STR_PAD_LEFT).":".str_pad(($totalSeconds % 60),2,0,STR_PAD_LEFT);
           // dd($totalTimeTaken);

            $data = [
                'id' => $request->id,
                'status' => $request->status,
                'total_question_attended' => $qu_counter['attended_question'],
                'correct_answer' =>  $qu_counter['right_answer'],
                'negative_marks' => $negetiveMarks,
                'total_marks' => $quizTotalMarks,
                'obtained_marks' => $obtained_marks,
                'total_time_taken'=>$totalTimeTaken
            ];

            $res = $table->saveData($data);
            $qu_counter['negative_marks'] = $negetiveMarks;
            $qu_counter['negetive_count'] = $negetiveCount;
            $qu_counter['totalTimeTaken'] = $totalTimeTaken;

            $qu_counter['total_marks'] = $quizTotalMarks;
            $qu_counter['final_marks'] = $obtained_marks;
            $qu_counter['total_qu_count'] = $quizTotalCount;
            $qu_counter['obtained_marks'] = $obtained_qu_marks;
            $qu_counter['not_visited'] = $quizTotalCount - $qu_counter['attended_question'];
        }
        return Response()->json(['qu_counter' => $qu_counter]);
    }
    public function specialTestQuizKeyAnswer(Request $request, $id)
    {
        $userQuizDetail = new UserQuizDetail();
        $userId = Auth::user()->id;
        $keyAnswers = $userQuizDetail->where(['id' => $id, 'user_id' => $userId])
            ->with(['quiz', 'quiz.quizDetail', 'quiz.quizDetail.question', 'userQuizQuestionDetail','quiz.specialCourse','quiz.stSubCourse'])
            ->first();
        if ($keyAnswers == null) {
            abort(403, 'Access denied');
        }
        // dd($keyAnswers->toArray());


        return view('User/specialTestKeyAnswers')
            ->with([
                'types' => $this->getTypes(),
                'key_answers' => $keyAnswers->toArray(),

            ]);
    }
}