<?php

namespace App\Http\Controllers;

use App;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Traits\ApiResponser;
use App\Models\CurrentAffair;
use App\Models\User;
use App\Models\Chapter;
use App\Models\Course;
use App\Models\Material;
use App\Models\Quiz;
use App\Models\SpecialTestCourse;
use App\Models\Subject;
use App\Models\Announcement;
use App\Models\UserQuizDetail;
use App\Models\UserQuizQuestionDetail;
use App\Models\SpecialTestSubCourse;
use App\Models\PaymentDetail;
use App\Models\WeeklyBuzz;
use App\Models\NotificationHistory;
use App\Models\YoutubeVideo;
use App\Models\QuizInstruction;
use App\Models\QuizDetail;
use App\Models\WeeklyBuzzFolder;
use Illuminate\Support\Facades\Storage;
use Illuminate\Pagination\Paginator;
class MobileUserController extends Controller
{
    use ApiResponser;
    function getMobileAppVertion(Request $request)
    {
         return $this->success(["serverVersion"=>"1.0.1","PlaystoreURL"=>"https://play.google.com/store/apps/details?id=com.stepin.gurudev"]);
    }

    /*-----Authentication Functions Starts Here Done By Pavan [18-10-21]--------------------*/
    function register(Request $request)
    {

        $exists = User::where(function ($q) use ($request) {
            $q->where('email', $request->email)
                ->orWhere('mobile', $request->mobile);
        })->first();

        if ($exists) {
            if ($exists->email == $request->email)
                return $this->error('Email Id Already Registered..!', 200);
            else if ($exists->mobile == $request->mobile)
                return $this->error('Mobile No Already Registered..!', 200);
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'mobile' => $request->mobile,
            'city' => $request->city,
            'zipcode' => $request->zipcode,
            'dob' => date('Y-m-d', strtotime($request->dateofbirth)),
            'password' => Hash::make($request->password),
        ]);
        $userCount = str_pad($user->id, 5, "0", STR_PAD_LEFT);
        $userCount = "GD" . date('Y') . $userCount;
        $user->user_id = $userCount;
        $query = $user->save();
        /*--------------------hold for sometime templete pending------------------------------------------*/
        // $type='Successful Registration, Your username '.$request->email.' and password '.$request->password.' for the login. Thank you GURIAS.';
        //     $result = $this->sendSmsGurudev($type, $request->mobile);

        $paymentDetails = [
            'user_id' => $user->id,
            'type' => 'Course',
            'type_id' => $request->course_id,
            'payment_date' => date('Y-m-d H:i:s'),
            'amount' => 0,
            'status' => 'Success'
        ];
        $res = PaymentDetail::create($paymentDetails);

        return $this->success([
            'token' => $user->createToken('API Token')->plainTextToken
        ], 'Registered Successfully.');
    }
    function login(Request $request)
    {
        /* $attr = $request->validate([
            'email' => 'required|string|email|',
            'password' => 'required|string|min:6'
        ]);*/

        $device_token = $request->device_token;
        $reqdata=$request->except('device_token');
        $reqdata['status'] = 'Active';
        if (!Auth::attempt($reqdata)) {
            if (!Auth::attempt(['mobile'=>$reqdata['email'],'password'=>$reqdata['password']])) {
               if($reqdata['password']=='Login from google'){
                    $existing_user = User::whereEmail($reqdata['email'])->first();
                    if(!Auth::loginUsingId($existing_user->id))
                     return $this->error('Invalid Email Id Or Password..', 200);
               }
               else   return $this->error('Invalid Email Id Or Password..', 200);
              
            }
       }
        //Auth::logoutOtherDevices($request->password);
        DB::table('personal_access_tokens')->where('tokenable_id', Auth::user()->id)->delete();
        $token = auth()->user()->createToken('API Token')->plainTextToken;

        $res = User::where('id', Auth::user()->id)->update(["device_token" => $device_token]);
        $user = auth()->user()->toArray();
        return $this->success([
            'token' => $token,
            'name' => $user['name'],
            'profile' => $user['profile'] != '' ? env('PUBLIC_PATH') . '/' . $user['profile'] : null,
            'dateofbirth' => $user['dob'] != '' ? date('m-d-Y', strtotime($user['dob'])) : null,
            'email' => $user['email']
        ]);
    }
    function logout(Request $request)
    {
        auth()->user()->tokens()->delete();
        return $this->success('Logout Successfully..!', []);
    }
    /*---------------Authentication Functions Ends Here-------------------------------------*/

    /*----------------Profile Details Of User-----------------------------------------------*/
    function profile(Request $request)
    {
        $userData = auth()->user()->toArray();

        $userData['profile'] = $userData['profile'] != '' ? env('PUBLIC_PATH') . '/' . $userData['profile'] : null;
        $userData['dateofbirth'] = $userData['dob'] != '' ? date('m-d-Y', strtotime($userData['dob'])) : null;
        $userData['course'] = PaymentDetail::where('type_id','<>',0)->where(['type'=>'Course','user_id'=>auth()->user()->id,'status'=>'Success'])->count();
        $userData['mcq'] = UserQuizDetail::whereHas('quiz',function ($q){$q->where('type',1);})->where(['user_id'=>auth()->user()->id,])->count();
        $userData['mockTest'] = UserQuizDetail::whereHas('quiz',function ($q){$q->whereIn('type',[2,3,4]);})->where(['user_id'=>auth()->user()->id])->count();
        return $this->success([
            $userData
        ]);
    }

    /*---------------------------- Current Affairs  remove once new app launched 26-seo-22-----------------------------------------*/
    function currentAffairs(Request $request, $slug = null)
    {

        $pulicPath = env("PUBLIC_PATH");
        if (!empty($slug)) {
            $data = CurrentAffair::where('slug', $slug)
                ->leftJoin('bookmarks', function ($q) {
                    $q->on('current_affairs.id', '=', 'bookmarks.type_id');
                    $q->where(['user_id' => auth()->user()->id, 'type' => 'CurrentAffairs']);
                })->orderBy('current_affairs.id', 'DESC')
                ->select(
                    'current_affairs.*',
                    DB::raw('DATE_FORMAT(date,"%m-%d-%Y") AS new_date'),
                    DB::raw("IF(image IS NULL, image, CONCAT('" . $pulicPath . "','/',image)) as image"),
                    DB::raw("IF(bookmarks.type IS NULL, false,true) as bookmark")

                )
                ->get()
                ->toArray();
        } else {
            $from_date = date('Y-m-d', strtotime($request->from_date));
            $searchTag = $request->searchTag;
            $to_date = date('Y-m-d', strtotime($request->to_date));

            $data = CurrentAffair::where(function ($q) use ($from_date, $to_date, $searchTag) {

                if ($searchTag != '') {
                    $q->where('tags', $searchTag);
                }
                if ($from_date != "1970-01-01" && $to_date != "1970-01-01") {
                    $q->whereBetween('date', [$from_date, $to_date]);
                } else if ($from_date != "1970-01-01" && $to_date == "1970-01-01") {
                    $q->where('date', $from_date);
                }
            })->leftJoin('bookmarks', function ($q) {
                $q->on('current_affairs.id', '=', 'bookmarks.type_id');
                $q->where(['user_id' => auth()->user()->id, 'type' => 'CurrentAffairs']);
            })
                ->select(
                    'current_affairs.*',
                    DB::raw('DATE_FORMAT(date,"%m-%d-%Y") AS new_date'),
                    DB::raw("IF(image IS NULL, image, CONCAT('" . $pulicPath . "','/',image)) as image"),
                    DB::raw("IF(bookmarks.type IS NULL, false,true) as bookmark")
                )
                ->orderBy('current_affairs.id', 'DESC');

            if ($request->limit > 0)
                $data = $data->limit($request->limit);

            $data = $data->get()->toArray();
            // dd($data);

        }
        return $this->success($data);
    }
     function currentAffairsNew(Request $request, $slug = null)
    {

        $pulicPath = env('PUBLIC_PATH');
         $currentPage = $request->page;
        Paginator::currentPageResolver(function () use ($currentPage) {
            return $currentPage;
        });
        if (!empty($slug)) {
            $data = CurrentAffair::where('slug', $slug)
                ->leftJoin('bookmarks', function ($q) {
                    $q->on('current_affairs.id', '=', 'bookmarks.type_id');
                    $q->where(['user_id' => auth()->user()->id, 'type' => 'CurrentAffairs']);
                })->orderBy('current_affairs.id', 'DESC')
                ->select(
                    'current_affairs.*',
                    DB::raw('DATE_FORMAT(date,"%m-%d-%Y") AS new_date'),
                    DB::raw("IF(image IS NULL, image, CONCAT('" . $pulicPath . "','/',image)) as image"),
                    DB::raw("IF(bookmarks.type IS NULL, false,true) as bookmark")

                )
                ->get()->toArray();
        } else {
            $from_date = date('Y-m-d', strtotime($request->from_date));
            $searchTag = $request->searchTag;
            $to_date = date('Y-m-d', strtotime($request->to_date));

            $data = CurrentAffair::where(function ($q) use ($from_date, $to_date, $searchTag) {

                if ($searchTag != '') {
                    $q->where('tags', $searchTag);
                }
                if ($from_date != "1970-01-01" && $to_date != "1970-01-01") {
                    $q->whereBetween('date', [$from_date, $to_date]);
                } else if ($from_date != "1970-01-01" && $to_date == "1970-01-01") {
                    $q->where('date', $from_date);
                }
            })->leftJoin('bookmarks', function ($q) {
                $q->on('current_affairs.id', '=', 'bookmarks.type_id');
                $q->where(['user_id' => auth()->user()->id, 'type' => 'CurrentAffairs']);
            })
                ->select(
                    'current_affairs.*',
                    DB::raw('DATE_FORMAT(date,"%m-%d-%Y") AS new_date'),
                    DB::raw("IF(image IS NULL, image, CONCAT('" . $pulicPath . "','/',image)) as image"),
                    DB::raw("IF(bookmarks.type IS NULL, false,true) as bookmark")
                )
                ->orderBy('current_affairs.id', 'DESC');

            if ($request->limit > 0)
                $data = $data->limit($request->limit);

            $data = $data->paginate(10)->toArray();
            // dd($data);

        }
        return $this->success($data);
    }

    /*-----------------------------Banner Images -------------------------------------------*/
    function bannerImages(Request $request)
    {
        $pulicPath = env('PUBLIC_PATH');
        $bannerImages = App\Models\BannerImages::where(['type' => 'Mobile'])
            ->select(
                'url',
                DB::raw("IF(image IS NULL, image, CONCAT('" . $pulicPath . "','/',image)) as image")
            )
            ->get()->toArray();
        return $this->success(
            $bannerImages
        );
    }

    /*----------------------------- Study Materials ----------------------------------------*/
    function studyMaterials(Request $request)
    {
        $pulicPath = env('PUBLIC_PATH');
        $searchString = $request->searchString;
        $searchTag = $request->searchTag;

        $data = Material::where('type', 'Study')
            ->where(function ($q) use ($searchTag, $searchString) {
                if ($searchTag != '') {
                    $q->where('tags', 'like', '%' . trim($searchTag) . '%');
                } else if ($searchString != '') {

                    $q->orWhere('title', 'like', '%' . $searchString . '%');
                    $q->orWhere('tags', 'like', '%' . trim($searchString) . '%');
                    $date = date('Y-m-d', strtotime($searchString));
                    if ($date != "1970-01-01")
                        $q->orWhere('date', $date);
                }
            })
            ->select(
                'materials.*',
                DB::raw('DATE_FORMAT(date,"%m-%d-%Y") AS new_date'),

                DB::raw("CONCAT('" . $pulicPath . "','/',material) as material")
            )

            ->orderBy('id', 'DESC')
            ->get()
            ->toArray();

        return $this->success(
            $data
        );
    }

    /*----------------------------- Video Materials ----------------------------------------*/
    function videoMaterials(Request $request)
    {
        $searchString = $request->searchString;
        $searchTag = $request->searchTag;
        $pulicPath = env('PUBLIC_PATH');

        $data = Material::where('type', 'Video')
            ->where(function ($q) use ($searchTag, $searchString) {
                if ($searchTag != '') {
                    $q->where('tags', 'like', '%' . trim($searchTag) . '%');
                } else if ($searchString != '') {

                    $q->orWhere('title', 'like', '%' . $searchString . '%');
                    $q->orWhere('tags', 'like', '%' . trim($searchString) . '%');
                    $date = date('Y-m-d', strtotime($searchString));
                    if ($date != "1970-01-01")
                        $q->orWhere('date', $date);
                }
            })
            ->select(
                'materials.*',
                DB::raw('DATE_FORMAT(date,"%m-%d-%Y") AS new_date'),
                DB::raw("IF(youtube_url IS NULL, youtube_url, SUBSTRING_INDEX(youtube_url,'=',-1)) as youtube_url")

            )
            ->orderBy('id', 'DESC')
            ->get()
            ->toArray();

        return $this->success(
            $data
        );
    }

    /*----------------------------- Live Class ---------------------------------------------*/
    function liveClass(Request $request)
    {
        $userId = auth()->user()->id;
        $startTime = date('Y-m-d H:i', strtotime('-20 minutes'));
        $date = "'" . date('Y-m-d H:i') . "'";

        $data = App\Models\LiveClass::with('batch')
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
            )->get()->toArray();

        return $this->success([
            $data
        ]);
    }

    /*----------------------------- BookMarks ---------------------------------------------*/
    function bookmarks(Request $request)
    {
        $searchString = $request->searchString;
        $searchTag = $request->searchTag;
        $pulicPath = env('PUBLIC_PATH');
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
        })->select(
            'current_affairs.*',
            DB::raw('DATE_FORMAT(date,"%m-%d-%Y") AS new_date'),
            'bookmarks.type_id',
            DB::raw("IF(image IS NULL, image, CONCAT('" . $pulicPath . "','/',image)) as image")
        )
            ->orderBy('current_affairs.id', 'DESC')
            ->get()
            ->toArray();


        return $this->success([
            empty($data) ? null : $data
        ]);
    }

    /*----------------------------- BookMarks Save-----------------------------------------*/
    function bookmark(Request $request)
    {
        if ($request->isMethod('post')) {
            $requestData = $request->all();
            $requestData['type'] = 'CurrentAffairs';
            $table = new App\Models\Bookmark();
            $res = $table->saveData($requestData);
            return $this->success([
                $res
            ], $res[1]);
        }
    }

    /*----------------------------- Course ------------------------------------------------*/
    function course(Request $request)
    {
        $searchString = $request->searchString;
        $pulicPath = env('PUBLIC_PATH');

        $data = Course::with('payment')
            ->where('status', 'Active')
            ->select("*", DB::raw("CONCAT('" . $pulicPath . "','/',background_image) as background_image"))
            ->orderBy('id', 'DESC')
            ->get();

        return $this->success(
            $data
        );
    }

    /*----------------------------- Subject ------------------------------------------------*/
    function subject($slug)
    {
        $data = Subject::leftJoin('chapters', function ($join) {
            $join->on('chapters.subject_id', '=', 'subjects.id')
                ->where('chapters.status', 'Active')
                ->where('chapters.deleted_at', null)
                ->where('chapters.date', '<=', date('Y-m-d'));
        })
            ->leftJoin('quizzes', function ($join) {
                $join->on('quizzes.subject_id', '=', 'subjects.id')
                    ->where('quizzes.status', 'Active')
                    ->where('quizzes.type', 0)
                    ->where('quizzes.deleted_at', null)
                    ->where('quizzes.publish_date', '<=', date('Y-m-d'));
            })
            ->wherehas('course', function ($q) use ($slug) {
                $q->where('slug', $slug);
            })->where('subjects.status', 'Active')
            ->select('subjects.*', DB::raw('COUNT(DISTINCT(chapters.id)) as chapters_count'), DB::raw('COUNT(DISTINCT(quizzes.id)) as quizs_count'))
            ->groupBy('subjects.id')
            ->orderBy('subjects.id', 'DESC')
            ->get()
            ->toArray();

        return $this->success(
            $data
        );
    }

    /*----------------------------- Subject ------------------------------------------------*/
    function chapter($slug)
    {
        $pulicPath = env('PUBLIC_PATH');
        $userId = auth()->user()->id;
        $data = Chapter::with(['course', 'course.payment'])
            ->wherehas('subject', function ($q) use ($slug) {
                $q->where('slug', $slug);
            })->where('date', '<=', date('Y-m-d'))
            ->where('status', 'Active')
            ->select(
                "*",
                DB::raw('DATE_FORMAT(date,"%m-%d-%Y") AS new_date'),
                DB::raw("CONCAT('" . $pulicPath . "','/',material) as material")
            )
            ->orderBy('id', 'DESC')->get()->toArray();
        // dd($$data);
        return $this->success(
            $data
        );
    }

    /*----------------------------- Course-Subject-Materials -------------------------------*/
    function material($id)
    {
        $userId = auth()->user()->id;
        $pulicPath = env('PUBLIC_PATH');

        $data = Chapter::with(['course', 'subject', 'course.payment'])
            ->where('date', '<=', date('Y-m-d'))
            ->where('id', $id)
            ->where('status', 'Active')
            ->select(
                'id',
                'course_id',
                'subject_id',
                'chapter',
                'date',
                'video_material',
                DB::raw('DATE_FORMAT(date,"%m-%d-%Y") AS new_date'),
                DB::raw("IF(material IS NULL, material, CONCAT('" . $pulicPath . "','/',material)) as material"),
                DB::raw("IF(video_material IS NULL, video_material, SUBSTRING_INDEX(video_material,'=',-1)) as video_material"),
                'type'
            )
            ->first();

        $finalArray['materials'][] = $data;

        $quiz = Quiz::with(['userQuizDetail' => function ($q) use ($userId) {
            $q->where('user_id', $userId);
        }])->whereHas('chapter', function ($q) use ($id) {
            $q->where('id', $id);
        })->where('status', 'Active')
            ->where('publish_date', '<=', date('Y-m-d'))
            ->first();

        if (!empty($quiz))
            $finalArray['quiz'][] = $quiz;


        if ($data->course->payment != null || $data->type == 'Free') {
            return $this->success([$finalArray]);
        } else {
            return $this->success([
                []
            ], 'Please Purchase this chapter to view material');
        }
    }

    /*----------------------------- Chapter Wise Quiz Test ---------------------------------*/
    function onlineTest($id)
    {
        $userId = auth()->user()->id;
        $quiz = Quiz::with([
            'quizDetail', 'quizDetail.question', 'chapter' => function ($chapter) {
                $chapter->select('id', 'course_id', 'subject_id', 'chapter', 'type');
            },
            'course' => function ($course) {
                $course->select('id', 'course', 'course_type');
            },
            'userQuizDetail' => function ($q) use ($userId) {
                $q->where('user_id', $userId);
            }
        ])
            ->where(['status' => 'Active', 'id' => $id])
            ->where('publish_date', '<=', date('Y-m-d'))
            ->first();

        $quiz_details = $quiz['quizDetail'];
        $quiz_details = $quiz_details->toArray();
        $totalMarks = 0;
        for ($i = 0; $i < sizeof($quiz_details); $i++) {
            $questions[$i]['id'] = $quiz_details[$i]['question']['id'];
            $questions[$i]['name'] = $quiz_details[$i]['question']['question'];
            $questions[$i]['marks'] = $quiz_details[$i]['question']['marks'];
            $questions[$i]['negative_marking'] = $quiz_details[$i]['question']['negative_marking'];
            $questions[$i]['marks'] = $quiz_details[$i]['question']['marks'];
            $totalMarks += $quiz_details[$i]['question']['marks'];
            // $questions[$i]['correct']=$quiz_details[$i]['question']['correct_answer'];
            $ans = [];
            for ($j = 0; $j < 6; $j++) {
                if ($quiz_details[$i]['question']["answer" . ($j + 1)] != '') {
                    $ans[$j]['id'] = $j + 1;
                    $ans[$j]['name'] = $quiz_details[$i]['question']["answer" . ($j + 1)];
                    if ("answer" . ($j + 1) == $quiz_details[$i]['question']['correct_answer']) {
                        $ans[$j]['correct'] = $quiz_details[$i]['question']['marks'];
                    } else {
                        $ans[$j]['correct'] = 0;
                    }
                }

                // $ans[$j]['correct'];
            }

            $questions[$i]['answer'] = $ans;
        }

        if ($quiz->userQuizDetail != null) {

            return $this->error('Quiz has already attended', 200);
        }
        if ($quiz->course->course_type != null || $quiz->course->course_type == 'Free') {
            $remainingTime = ((date('H', strtotime($quiz['total_time'])) * 60 + date('i', strtotime($quiz['total_time']))) * 60);

            return $this->success([
                'id' => $quiz['id'],
                'quiz_name' => $quiz['quiz_name'],
                'end_time' => $remainingTime,
                'pass-marks' => $quiz['pass-marks'],
                'start_time' => $remainingTime,
                'total_time' => $quiz['total_time'],
                'total_questions' => sizeof($quiz_details),
                'total_marks' => $totalMarks,

                'questions' => $questions

            ]);
        } else {
            return $this->success([
                'questions' => [],
            ], 'Please Purchase this chapter to view material');
        }
    }
    function courseQuizSave(Request $request)
    {

        $table1 = new UserQuizDetail();
        $table2 = new UserQuizQuestionDetail();
        $data['user_id'] = Auth::user()->id;
        $data['quiz_id'] = $request->question_allocation_id;
        $data['total_time_taken'] = $request->total_time_taken;
        $data['total_question_attended'] = $request->total_question_attended;
        $data['correct_answer'] = $request->correct_answer;
        $data['negative_marks'] = $request->negative_marking;
        //$data['total_marks'] = $request->correct_answer - $request->negative_marking;
        $data['total_marks'] = $request->total_marks;
        $data['obtained_marks'] = $request->obtained_marks;

        // dd($request->input());
        $retry = UserQuizDetail::where(['user_id' => $data['user_id'], 'quiz_id' => $data['quiz_id']])->select('id')->first();
        if (!empty($retry)) {
            $data['id'] = $retry['id'];
            UserQuizQuestionDetail::where(['user_quiz_detail_id' => $data['id']])->delete();
        }

        $data2 = [];
        $id = $table1->saveData($data);
        // dd($data);
        $second_table = json_decode($request->quizval);

        foreach ($second_table as $key => $item) {
            $temp_array['user_quiz_detail_id'] = $id;
            $temp_array['question_id'] = $key;
            $temp_array['given_answer'] = "answer" . $item;
            $temp_array['created_at'] = date('Y-m-d H:i:s');

            array_push($data2, $temp_array);
        }
        $res = $table2->saveData($data2);
        // return Response()->json(array('result'=>$res,'id'=>$id));
        $data = $request->input();
        $data['keyAnsId'] = $id;
        return $this->success($data);
    }
    /*----------------------------- MCQ ----------------------------------------------------*/
    function mcq(Request $request)
    {
        $searchString = $request->searchString;

        $date = date('Y-m-d');
        if ($searchString != '') {
            $searchString = date('Y-m-d', strtotime($searchString));
            if ($searchString != "1970-01-01")
                $date = $searchString;
        }
        $userId = auth()->user()->id;

        $quiz = Quiz::with(['userQuizDetail' => function ($q) use ($userId) {
            $q->where('user_id', $userId);
        }])->where(['type' => 1, 'status' => 'Active'])
            ->whereRaw("publish_date BETWEEN ((select MAX(publish_date) from quizzes WHERE `type`=1 AND deleted_at IS NULL) - INTERVAL 30 DAY) AND (select MAX(publish_date) from quizzes where `type`=1 AND deleted_at IS NULL)")
            ->select(
                'id',
                'quiz_name',
                'publish_date',
                DB::raw('DATE_FORMAT(publish_date,"%m-%d-%Y") AS new_date'),
                DB::raw('ROUND(TIME_TO_SEC(str_to_date(total_time,"%H:%i"))/60) AS total_time'),
                'description',
                'total_questions'
            )
            ->orderBy('publish_date', 'DESC')
            ->get()->toArray();

        return $this->success($quiz);
    }

    /*----------------------------- MCQ TEST Questions -------------------------------------*/
    function mcqTest($id)
    {
        $userId = auth()->user()->id;
        $quiz = Quiz::with([
            'quizDetail',
            'quizDetail.question',
            'userQuizDetail' => function ($q) use ($userId) {
                $q->where('user_id', $userId);
            }
        ])->where(['status' => 'Active', 'id' => $id])
            ->where('publish_date', '<=', date('Y-m-d'))
            ->select(
                'id',
                'quiz_name',
                'publish_date',
                DB::raw('DATE_FORMAT(publish_date,"%m-%d-%Y") AS new_date'),
                'total_time',
                'description',
                'total_questions'
            )
            ->first()
            ->toArray();

        if ($quiz['user_quiz_detail'] != null) {
            return $this->error('MCQ has already attended', 200);
        }
        $quiz_details = $quiz['quiz_detail'];
        $totalMarks = 0;
        for ($i = 0; $i < sizeof($quiz_details); $i++) {
            $questions[$i]['id'] = $quiz_details[$i]['question']['id'];
            $questions[$i]['name'] = $quiz_details[$i]['question']['question'];
            $questions[$i]['marks'] = $quiz_details[$i]['question']['marks'];
            $questions[$i]['negative_marking'] = $quiz_details[$i]['question']['negative_marking'];
            $totalMarks += $quiz_details[$i]['question']['marks'];
            // $questions[$i]['correct']=$quiz_details[$i]['question']['correct_answer'];
            $ans = [];
            for ($j = 0; $j < 6; $j++) {

                if ($quiz_details[$i]['question']["answer" . ($j + 1)] != null) {
                    $ans[$j]['id'] = $j + 1;
                    $ans[$j]['name'] = $quiz_details[$i]['question']["answer" . ($j + 1)];

                    if ("answer" . ($j + 1) == $quiz_details[$i]['question']['correct_answer']) {
                        $ans[$j]['correct'] = $quiz_details[$i]['question']['marks'];
                    } else {
                        $ans[$j]['correct'] = 0;
                    }
                    // $ans[$j]['correct'];
                }
                // $ans[$j]['correct'];
            }

            // dd($ans);
            $questions[$i]['answer'] = $ans;
        }




        $remainingTime = ((date('H', strtotime($quiz['total_time'])) * 60 + date('i', strtotime($quiz['total_time']))) * 60);


        return $this->success([[
            'id' => $quiz['id'],
            'quiz_name' => $quiz['quiz_name'],
            'end_time' => $remainingTime,
            'pass-marks' => $quiz['pass-marks'],
            'start_time' => $remainingTime,
            'total_time' => $quiz['total_time'],
            'total_questions' => sizeof($quiz_details),
            'total_marks' => $totalMarks,
            'questions' => $questions

        ]]);
    }

    function currentAffairsMCQQuizSave(Request $request)
    {


        $table1 = new UserQuizDetail();
        $table2 = new UserQuizQuestionDetail();
        $data['user_id'] = Auth::user()->id;
        $data['quiz_id'] = $request->question_allocation_id;
        $data['total_time_taken'] = $request->total_time_taken;
        $data['total_question_attended'] = $request->total_question_attended;
        $data['correct_answer'] = $request->correct_answer;
        $data['negative_marks'] = $request->negative_marking;
        //$data['total_marks']=$request->correct_answer-$request->negative_marking;

        $data['total_marks'] = $request->total_marks;
        $data['obtained_marks'] = $request->obtained_marks;

        // dd($request->input());
        $retry = UserQuizDetail::where(['user_id' => $data['user_id'], 'quiz_id' => $data['quiz_id']])->select('id')->first();
        if (!empty($retry)) {
            $data['id'] = $retry['id'];
            UserQuizQuestionDetail::where(['user_quiz_detail_id' => $data['id']])->delete();
        }

        $data2 = [];
        $id = $table1->saveData($data);
        // dd($data);
        $second_table = json_decode($request->quizval);

        foreach ($second_table as $key => $item) {
            $temp_array['user_quiz_detail_id'] = $id;
            $temp_array['question_id'] = $key;
            $temp_array['given_answer'] = "answer" . $item;
            $temp_array['created_at'] = date('Y-m-d H:i:s');

            array_push($data2, $temp_array);
        }
        $res = $table2->saveData($data2);
        // return Response()->json(array('result'=>$res,'id'=>$id));
        $data = $request->input();
        $data['keyAnsId'] = $id;
        return $this->success($data);
    }

    /*----------------------------- Special TEST Courses -------------------------------------*/
    function specialTestCourse()
    {
        $data = SpecialTestCourse::with(['payment'])
            ->leftJoin('quizzes', function ($join) {
                $join->on('quizzes.course_id', '=', 'special_test_courses.id')
                    ->where(['quizzes.status' => 'Active', 'quizzes.deleted_at' => null]);

            })
            ->select('special_test_courses.*', DB::raw('COUNT(DISTINCT(quizzes.id)) as quiz_count'))
            ->groupBy('special_test_courses.id')
            ->orderBy('id', 'DESC')
            ->get()->toArray();

        return $this->success(
            $data
        );
    }

    /*----------------------------- Special TEST Courses - Quiz ------------------------------*/
    function specialTestQuizList(Request $request, $slug)
    {
        $date = date('Y-m-d');
        $userId = auth()->user()->id;
        $specialTestSubCourse = [];
        if ($request->courseType == 2) {
            $specialTestSubCourse = Optional(SpecialTestSubCourse::with(['payment'])
                ->leftJoin('quizzes', function ($join) {
                    $join->on('quizzes.subject_id', '=', 'special_test_sub_courses.id')
                        ->where(['quizzes.status' => 'Active', 'quizzes.type' => 4, 'quizzes.deleted_at' => null]);

                })
                ->with('course', function ($q) use ($slug) {
                    $q->where('slug', $slug);
                })
                ->select('special_test_sub_courses.*', DB::raw('COUNT(DISTINCT(quizzes.id)) as quiz_count'))
                ->whereHas('course', function ($q) use ($slug) {
                    $q->where('slug', $slug);
                })
                ->groupBy('special_test_sub_courses.id')
                ->orderBy('id', 'DESC')->get())->toArray();

            $quiz = Quiz::with(['specialCourse.payment', 'userQuizDetail' => function ($q) use ($userId) {
                $q->where('user_id', $userId);
            }])
                ->whereHas('specialCourse', function ($q) use ($slug) {
                    $q->where('slug', $slug);
                })->where(['type' => 2, 'status' => 'Active'])
                ->select('quizzes.*', DB::raw('DATE_FORMAT(publish_date,"%m-%d-%Y") AS new_date'), DB::raw('ROUND(TIME_TO_SEC(str_to_date(total_time,"%H:%i"))/60) AS total_time'))
                ->orderBy('id', 'DESC')
                ->get();
        } else {
            //dd($slug);
            $quiz = Quiz::with(['stSubCourse.payment', 'userQuizDetail' => function ($q) use ($userId) {
                $q->where('user_id', $userId);
            }])->whereHas('stSubCourse', function ($q) use ($slug) {
                $q->where('id', $slug);
            })->select('quizzes.*', DB::raw('DATE_FORMAT(publish_date,"%m-%d-%Y") AS new_date'), DB::raw('ROUND(TIME_TO_SEC(str_to_date(total_time,"%H:%i"))/60) AS total_time'))
                ->where(['type' => 4, 'status' => 'Active'])

                ->orderBy('id', 'DESC')->get();
        }
        // dd($specialTestSubCourse->count());
        if ($quiz->count() == 0 && ($specialTestSubCourse == null || empty($specialTestSubCourse))) {
            return $this->error('No Test for this Course', 200);
        }
        if ($quiz[0]->specialCourse->payment != null || $quiz[0]->specialCourse->type == 'Free' || $specialTestSubCourse != null) {
            return $this->success(
                ['subCourse' => $specialTestSubCourse, 'quiz' => $quiz->toArray()]
            );
        } else {
            return $this->error('Please Purchase Course to view material', 200);
        }
    }

    /*----------------------------- Special TEST Courses - Quiz -Questions -------------------*/


    function specialTestOnlineTest($id)
    {
        $userId = auth()->user()->id;
        $quizData = Quiz::with(['quizDetail', 'quizDetail.question', 'userQuizDetail' => function ($q) use ($userId) {
            $q->with('userQuizQuestionDetail');
            $q->where('user_id', $userId);
        }])->where(['status' => 'Active', 'id' => $id])
            ->select('quizzes.*')
            ->orderBy('id', 'DESC')
            ->first();

        $quiz = $quizData->toArray();
        if ($quiz['user_quiz_detail'] != null) {
            //   return $this->error('Special test has already completed', 200);
        }

        $start_date_time = $quiz['start_date_time'];
        $currentTime = date('Y-m-d H:i:s');
        $total_time=$minutes = date('H', strtotime($quiz['total_time'])) * 3600 + (date('i', strtotime($quiz['total_time']))*60);
        if ($quiz['user_quiz_detail']['total_time_taken'] != '') {
            $timeTaken = date('H', strtotime($quiz['user_quiz_detail']['total_time_taken'])) * 3600 + (date('i', strtotime($quiz['user_quiz_detail']['total_time_taken'])))*60+ (date('s', strtotime($quiz['user_quiz_detail']['total_time_taken'])));

            $minutes = $minutes - $timeTaken;
        }
         $isQuizStart = strtotime($currentTime) - strtotime($start_date_time);

        if ($isQuizStart < 0) {
            return $this->error("Special test starts at " . date('Y-m-d h:i A', strtotime($start_date_time)), 200);
        }
        $quiz_details = $quiz['quiz_detail'];
        $totalMarks = 0;
        $answerMap = [];
        $lastVisitedQuesion = [
            'id'=>0,
            'question_index'=>0
        ];

        // if (!empty($quiz['user_quiz_detail']['user_quiz_question_detail']))
        //     $userVisitedQuesionIds = $quizData->userQuizDetail->userQuizQuestionDetail->pluck('question_id')->toArray();
        // else {
        //     $lastVisitedQuesion['id'] = $quiz_details[0]['question']['id'];
        //     $lastVisitedQuesion['question_index'] = 0;
        // }

        $categoryTimings=[];
        $nextCat=[];
        for ($i = 0; $i < sizeof($quiz_details); $i++) {
            if ($quiz['user_quiz_detail']['last_attended_id']==$quiz_details[$i]['question']['id']) {
                $lastVisitedQuesion['id'] = $quiz_details[$i]['question']['id'];
                $lastVisitedQuesion['question_index'] = $i;
            }
            $questions[$i]['id'] = $quiz_details[$i]['question']['id'];
            $questions[$i]['name'] = $quiz_details[$i]['question']['question'];
            $questions[$i]['negative_marking'] = $quiz_details[$i]['question']['negative_marking'];
            $questions[$i]['marks'] = $quiz_details[$i]['question']['marks'];
            $category = $questions[$i]['category'] = $quiz_details[$i]['category'];
            $categoryTimings[$questions[$i]['category']]=$quiz_details[$i]['category_time'];
            $totalMarks += $quiz_details[$i]['question']['marks'];
            $catSize = ($answerMap[$quiz_details[$i]['category']]==null)?0:sizeof($answerMap[$quiz_details[$i]['category']]);
            if($catSize==0){
                $nextCat[$quiz_details[$i]['category']][0]=$i+1;
           }
            if ($i == 0) {
                $answerMap[$category][$questions[$i]['id']] = [$catSize, "not-answered", $i + 1, 0, $category,0,0];
            } else {
                $answerMap[$category][$questions[$i]['id']] = [$catSize, "not-visited", $i + 1, 0, $category,0,0];
            }
            $ans = [];
            for ($j = 0; $j < 6; $j++) {

                if ($quiz_details[$i]['question']["answer" . ($j + 1)] != null) {
                    $ans[$j]['id'] = $j + 1;
                    $ans[$j]['name'] = $quiz_details[$i]['question']["answer" . ($j + 1)];

                    if ("answer" . ($j + 1) == $quiz_details[$i]['question']['correct_answer']) {
                        $ans[$j]['correct'] = $quiz_details[$i]['question']['marks'];
                    } else {
                        $ans[$j]['correct'] = 0;
                    }
                    // $ans[$j]['correct'];
                }
            }
            // dd($ans);
            $questions[$i]['answer'] = $ans;
        }
        foreach ($quiz['user_quiz_detail']['user_quiz_question_detail'] as $data) {
            $answerMap[$data['category']][$data['question_id']][1] = $data['status'];
            $answerMap[$data['category']][$data['question_id']][3] = (int)substr($data['given_answer'], -1);
            $answerMap[$data['category']][$data['question_id']][5] = $data['marks'];
            $answerMap[$data['category']][$data['question_id']][6] = $data['neg_marks'];
        }
        $date = '2007-05-14';
        $datetime = strtotime($date."00:00:00");
        $categoryTimingsSec=$categoryTimeTaken=[];
        $spndTime=json_decode($quiz['user_quiz_detail']['category_info'],true);

        foreach($categoryTimings as $cat=>$time){
            $tempCat[]=$cat;
            if($time!="00:00:00"){
                $totSec=strtotime("$date $time") - $datetime;
                $categoryTimeTaken[$cat]=0;
                if($spndTime[$cat]!="00:00:00" && $spndTime[$cat]!=null){
                    $categoryTimeTaken[$cat]=strtotime("$date $spndTime[$cat]")- $datetime;
                    $totSec -=strtotime("$date $spndTime[$cat]") - $datetime;
                }
                $categoryTimingsSec[$cat]= $totSec;
            }
        }
        foreach($tempCat as $index=>$cat){
            $nextCat[$cat][0]=$nextCat[$tempCat[$index+1]][0];
            $nextCat[$cat][1]=$tempCat[$index+1];
      }

        return $this->success([
            'id' => $quiz['id'],
            'quiz_name' => $quiz['quiz_name'],
            'end_time' => $minutes,
            'categoryTimings'=>$categoryTimings,
            'categorySpendTimings'=>json_decode($quiz['user_quiz_detail']['category_info']),
            'categoryTimingsSec'=>$categoryTimingsSec,
            'categoryTimeTaken'=>$categoryTimeTaken,
            'nextCategories'=>$nextCat,
            'pass-marks' => 10,
            'total_time_sec' =>$total_time,
            'total_time' => $quiz['total_time'],
            'total_questions' => sizeof($quiz_details),
            'total_marks' => $totalMarks,
            'first_category' => $quiz_details[0]['category'],
            'answerMap' => $answerMap,
            'questions' => $questions,
            'last_visited_question'=>$lastVisitedQuesion
        ]);
    }
    /*----------------------------- Special TEST Quiz save - Quiz -Questions -------------------*/
    function specialTestQuizSave(Request $request)
    {

        $table1 = new UserQuizDetail();
        $table2 = new UserQuizQuestionDetail();
        $data['user_id'] = Auth::user()->id;
        $data['quiz_id'] = $request->question_allocation_id;
        $timeInfo =json_decode($request->total_time_taken,true);
        $data['total_question_attended'] = $request->total_question_attended;
         $data['last_attended_id'] = $request->last_visited_question_id;
        $catTime=[];
        $totSeconds=0;
        //dd($request->input());
        foreach($timeInfo as $cat=>$seconds){
           $catTime[$cat] = sprintf('%02d:%02d:%02d', ($seconds/ 3600),($seconds/ 60 % 60), $seconds% 60);
            $totSeconds+=$seconds;
        }
        $data['category_info']=json_encode($catTime);
        $data['total_time_taken']=sprintf('%02d:%02d:%02d', ($totSeconds/ 3600),($totSeconds/ 60 % 60), $totSeconds% 60);

        $data['status'] = $request->status;
        //$data['total_marks'] = $request->correct_answer - $request->negative_marking;

        // dd($request->input());
        $retry = UserQuizDetail::where(['user_id' => $data['user_id'], 'quiz_id' => $data['quiz_id']])->select('id')->first();
        if (!empty($retry)) {
            $data['id'] = $retry['id'];
            UserQuizQuestionDetail::where(['user_quiz_detail_id' => $data['id']])->delete();
        }


        $data2 = [];
        $id = $table1->saveData($data);

        $finalData['correct_answer'] = 0;
        $finalData['wrong_answered'] = 0;
        $finalData['negative_marks'] = 0;
        $finalData['total_marks'] = 0;
        $finalData['obtained_marks'] = 0;
        $finalData['total_questions_attended'] = 0;
        $finalData['questions_not_attended'] = 0;
        $finalData['not_answered'] = 0;
        $datawith_status = json_decode($request->reviewAnswer);
        // return $this->success($second_table);

        foreach ($datawith_status as $category => $answers) {

            foreach ($answers as $question_id => $item) {
                $review = 0;
                if ($item[1] != 'not-visited') {
                    if ($item[1] == 'not-answered' || $item[1] == 'review') {
                        $finalData['not_answered']++;
                    }
                    if ($item[1] == 'review' || $item[1] == 'answered-and-mark') {
                        $review = 1;
                    }
                    $answer = "";
                    if ($item[1] == 'Answered' || $item[1] == 'answered-and-mark') {
                        $answer = "answer" . $item[3];
                    }
                    $temp_array['user_quiz_detail_id'] = $id;
                    $temp_array['question_id'] = $question_id;
                    $temp_array['category'] = $category;
                    $temp_array['mark_review'] = $review;
                    $temp_array['given_answer'] = $answer;
                    $temp_array['status'] = $item[1];
                    $temp_array['marks'] = $item[5];
                    $temp_array['neg_marks'] = $item[6];
                    $temp_array['created_at'] = date('Y-m-d H:i:s');
                    array_push($data2, $temp_array);


                    if ($item[5] > 0) {
                        // Correct Answered Marks
                        $finalData['correct_answer']++;
                        $finalData['obtained_marks'] += $item[5];
                    } else if($answer!=''){
                        // Wrong Answered Marks
                        $finalData['negative_marks'] += $item[6];
                        $finalData['wrong_answered']++;
                    }
                    $finalData['total_questions_attended']++;
                } else {
                    $finalData['questions_not_attended']++;
                }
            }
        }
        $quizTotalMarks = QuizDetail::where(['quiz_id' => $data['quiz_id']])
            ->join('questions AS Question', function ($question) {
                $question->on('Question.id', '=', 'quiz_details.question_id');
            })->sum('marks');

        $finalData['final_marks'] = $finalData['obtained_marks'] - $finalData['negative_marks'];
        $finalData['quiz_total_marks'] = $quizTotalMarks;
        $finalData['percentage'] = ($finalData['final_marks']/$finalData['quiz_total_marks'])*100;
        $table1->where(['id' => $id])->update([
            'total_question_attended' => $finalData['total_questions_attended'],
            'correct_answer' => $finalData['correct_answer'],
            'negative_marks' => $finalData['negative_marks'],
            'total_marks' => $finalData['quiz_total_marks'],
            'obtained_marks' => $finalData['final_marks'],
        ]);


        array_push($data, $finalData);


        $res = $table2->saveData($data2);
        // return Response()->json(array('result'=>$res,'id'=>$id));
        $data = $request->input();
        $finalData['keyAnsId'] = $id;
        return $this->success($finalData);
    }

    /*----------------------------- Notifications-------------------*/
    function notifications(Request $request, $slug = null)
    {
        $pulicPath = env('PUBLIC_PATH');
        $searchString = $request->searchString;
        $user_id = Auth::user()->id;
        $announcement = Announcement::with(['history' => function ($q) use ($user_id) {
            $q->where('user_id', $user_id);
        }])->where(function ($q) use ($slug) {
            if ($slug != '')
                $q->where('slug', $slug);
        })->select(
            'announcements.*',
            DB::raw('DATE_FORMAT(date,"%d-%b-%Y") AS new_date'),
            DB::raw("IF(attachment IS NULL, attachment, CONCAT('" . $pulicPath . "','/',attachment)) as attachment"),
            DB::raw("IF(pdf IS NULL, pdf, CONCAT('" . $pulicPath . "','/',pdf)) as pdf")

        )->orderBy('id', 'DESC')->get()->toArray();
        $finalData = [];
        $newArray = [];
        $index = 0;
        //dd($announcement);
        foreach ($announcement as $list) {
            $finalData[$list['new_date']][] = $list;
        }
        $i = 0;
        foreach ($finalData as $key => $list) {
            $newArray[$i]['notificationdate'] = $key;
            foreach ($list as $key => $data) {
                $temp['heading'] = $data['title'];
                $temp['img'] = $data['attachment'];
                $temp['desc'] = $data['description'];
                $temp['slug'] = $data['slug'];
                $temp['pdf'] = $data['pdf'];
                $temp['url'] = $data['url'];
                $temp['id'] = $data['id'];
                $temp['date'] = $data['new_date'];
                $temp['is_read'] = ($data['history'] == null) ? 0 : 1;

                $newArray[$i]['data'][] = $temp;
                if ($slug != '') {
                    $newArray = [$temp];
                    $this->notificationHistoryUpdate($data['id']);
                }
            }
            $i++;
        }


        return $this->success(
            $newArray
        );
    }
    /*----------------------------- resetUserPassword-------------------*/
    function resetUserPassword(Request $request)
    {
        $res = User::where('id', Auth::user()->id)->update(["password" => Hash::make($request->password)]);
        return $this->success(null, 'Password Changed Successfully');
    }
    /*-----------------------------Banner Images+course+current affairs -------------------------------------------*/
    function homePage(Request $request)
    {
        $pulicPath = env('PUBLIC_PATH');
        $bannerImages = App\Models\BannerImages::where(['type' => 'Mobile'])
            ->select(
                'url',
                DB::raw("IF(image IS NULL, image, CONCAT('" . $pulicPath . "','/',image)) as image")
            )->get()->toArray();
        $searchString = $request->searchString;
        // $pulicPath=env('PUBLIC_PATH');

        $course_data = Course::where('status', 'Active')->with(['selected' => function ($e) {
            $e->select('id', 'user_id', 'type_id');
        }])
            ->select('id', 'course', 'slug')
            //  DB::raw("CONCAT('".$pulicPath."','/',background_image) as background_image"))
            ->orderBy('id', 'DESC');
        if ($request->limit = 4)
            $course_data = $course_data->limit($request->limit);

        $course_data = $course_data->take(6)->get()->toArray();

        // ->toArray();
           //dd(sizeof($course_data));
        for($i=0;$i<=(6-sizeof($course_data));$i++){
            $course_data[]=[
                "id"=>0,
                "course"=> "",
                "slug"=>"",
                "selected"=> null
            ];
        }


        $pulicPath = env('PUBLIC_PATH');
        if (!empty($slug)) {
            $data = CurrentAffair::where('slug', 'like', '%' . $slug . '%')
                ->leftJoin('bookmarks', function ($q) {
                    $q->on('current_affairs.id', '=', 'bookmarks.type_id');
                    $q->where(['user_id' => auth()->user()->id, 'type' => 'CurrentAffairs']);
                })
                ->select(
                    'current_affairs.*',
                    DB::raw('DATE_FORMAT(date,"%m-%d-%Y") AS new_date'),
                    DB::raw("IF(image IS NULL, image, CONCAT('" . $pulicPath . "','/',image)) as image"),
                    DB::raw("IF(bookmarks.type IS NULL, false,true) as bookmark")
                )
                ->orderBy('current_affairs.id', 'DESC')
                ->take(6)
                ->get()
                ->toArray();
        } else {
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
            })->leftJoin('bookmarks', function ($q) {
                $q->on('current_affairs.id', '=', 'bookmarks.type_id');
                $q->where(['user_id' => auth()->user()->id, 'type' => 'CurrentAffairs']);
            })
                ->select(
                    'current_affairs.*',
                    DB::raw('DATE_FORMAT(date,"%m-%d-%Y") AS new_date'),
                    DB::raw("IF(image IS NULL, image, CONCAT('" . $pulicPath . "','/',image)) as image"),
                    DB::raw("IF(bookmarks.type IS NULL, false,true) as bookmark")
                )
                ->orderBy('current_affairs.id', 'DESC');

            if ($request->limit = 4)
                $data = $data->limit($request->limit);

            $data = $data->take(6)->get()->toArray();
            // dd($data);
        }
        $videos = Material::where(['type' => 'Video', 'for_dashboard' => 1])
            ->select(
                'id',
                'title',
                DB::raw("IF(youtube_url IS NULL, youtube_url, SUBSTRING_INDEX(youtube_url,'=',-1)) as youtube_url")
            )->orderBy('id', 'DESC')->take(5)
            ->get()
            ->toArray();

        $notificationCount = Announcement::leftJoin('notification_histories',  function ($leftJoin) {
            $leftJoin->on('notification_histories.notification_id', '=', 'announcements.id')
                ->where('notification_histories.user_id', '=', auth()->user()->id);
        })->where('notification_histories.user_id', NULL)->count();
        // dd($notificationCount);
        $marqueeText = App\Models\BannerImages::where(['type' => 'Marquee Text'])
        ->select('url','image as marqueeText')->get()->toArray();

        return $this->success(
            [
                ['bannerImages' => $bannerImages],
                ['courseData' => $course_data],
                ['marqueeText' => $marqueeText],
                ['currentAffairs' => $data],
                ['videos' => $videos],
                ['notificationCount' => $notificationCount],
                
            ]
        );
    }
    /*----------------------------- Weekly Buzz ----------------------------------------*/
       function weeklyBuzzFolder()
    {
        $data = WeeklyBuzzFolder::orderBy('id', 'DESC')
            ->get()
            ->toArray();
        return $this->success(
            $data
        );
    }
    function weeklyBuzz(Request $request)
    {
        $pulicPath = env('PUBLIC_PATH');
        $searchString = $request->searchString;
        $data = WeeklyBuzz::where('weekly_buzz_folder_id',$request->folder_id)
        ->where(function ($q) use ($searchString) {
            if ($searchString != '') {

                $q->orWhere('title', 'like', '%' . $searchString . '%');
                $date = date('Y-m-d', strtotime($searchString));
                if ($date != "1970-01-01")
                    $q->orWhere('date', $date);
            }
        })
            ->select(
                'weekly_buzzs.*',
                DB::raw('DATE_FORMAT(date,"%m-%d-%Y") AS new_date'),

                DB::raw("IF(attachment IS NULL, attachment,CONCAT('" . $pulicPath . "','/',attachment)) as attachment"),
                DB::raw("IF(thumbnail IS NULL, thumbnail, CONCAT('" . $pulicPath . "','/',thumbnail)) as thumbnail")
            )

            ->orderBy('id', 'DESC')
            ->get()
            ->toArray();

        return $this->success(
            $data
        );
    }
    //--------------------Validate Mobile No AND Send OTP During Registration-----------------------------
    public function validateMobile(Request $request,$hash_code)
    {

        $users = new User();
        // $res=$users->deleteRecord(1);
        $user = $users->where('mobile', $request->mobile)->first();
       // dd($user); 
        if (empty($user)) {
           //echo $hash_code;
          //  dd($hash_code);
            $generate_otp = rand(100000, 999999);
            //$type = 'Dear Student, OTP is ' . $generate_otp . ' for Registration. Thank you GURIAS';
            $type='<#> GuruDev Registration/Forgot Password code is : '.$generate_otp.' '.$hash_code;
            $result = $this->sendSmsGurudev($type, $request->mobile);
           
            return $this->success([['otp' => $generate_otp]]);
        } else {
            return $this->error('Mobile Number Exist..', 200);
        }
    }
    //--------------------Validate Mobile No AND Send OTP forgot password-----------------------------
    public function generateOtp(Request $request,$hash_code)
    {
        $users = new User();
        // $res=$users->deleteRecord(1);
        $user = $users->where('mobile', $request->mobile)->first();
        if (!empty($user)) {
            $generate_otp = rand(100000, 999999);
            //$type = 'Dear Student, OTP is ' . $generate_otp . ' for reset-password. Thank you GURIAS';
            $type='<#> GuruDev Registration/Forgot Password code is : '.$generate_otp.' '.$hash_code;
            $result = $this->sendSmsGurudev($type, $request->mobile);
            //dd($result);
            return $this->success([['otp' => $generate_otp]]);
        } else {
            return $this->error('Invalid Mobile Number ..', 200);
        }
    }
    /*----------------------------- resetUserPassword-------------------*/
    function resetForgotUserPassword(Request $request)
    {
        $res = User::where('mobile', $request->mobile)->update(["password" => Hash::make($request->password)]);
        return $this->success(null, 'Password Changed Successfully');
    }
    function profileUpdate(Request $request)
    {

        if ($request->name != '' && $request->dob != '' && $request->email != '') {
            // dd($request->input());
            $res = User::where('id', Auth::user()->id)->update([
                "name" => $request->name,
                'dob' => date('Y-m-d', strtotime($request->dob)), 'email' => $request->email, 'city' => $request->city, 'zipcode' => $request->zipcode,
            ]);
        } elseif ($request->photo != '') {
            $base64_str = substr($request->photo, strpos($request->photo, ",") + 1);
            $pos  = strpos($request->photo, ';');
            $extension = "jpeg";explode('/', explode(':', substr($request->photo, 0, $pos))[1])[1];
            $image = base64_decode($base64_str);
            $newFileName = rand(10, 100) . date('Y-m-d_H-i-s') . '.' . $extension;
            $output_file='description'.$extension;
            $ifp = fopen( $output_file, 'wb' );        
            fwrite( $ifp, $image );
            $s3 = Storage::disk('azure');
            $destinationPath = 'Uploads/User/'.$newFileName;
            $s3->put($destinationPath,file_get_contents($output_file),'public');            
            $res = User::where('id', Auth::user()->id)->update(["profile" => 'Uploads/User/' . $newFileName]);
        } else {
            return $this->error('Invalid Fields ..', 200);
        }
        return $this->success(null, 'Profile Updated Successfully1');
    }


    function keyAnswers($id)
    {
        $userQuizDetail = new UserQuizDetail();
        $userId = Auth::user()->id;

        $keyAnswers = $userQuizDetail->where(['id' => $id, 'user_id' => $userId])
            ->with(['quiz', 'quiz.quizDetail', 'quiz.quizDetail.question', 'userQuizQuestionDetail'])
            ->first();
        if ($keyAnswers == null) {
            return $this->error('Access denied', 200);
        }
        return $this->success([['keyAnswers' => $keyAnswers]]);
    }
    function notificationHistoryUpdate($notification_id)
    {
        try {
            $isExist = NotificationHistory::where(['user_id' => Auth::user()->id, "notification_id" => $notification_id])->first();
            if (!$isExist) {
                $res = NotificationHistory::create(['user_id' => Auth::user()->id, "notification_id" => $notification_id, 'read_at' => date('Y-m-d H:i')]);
            }
        } catch (Exception $e) {
        }
    }
    function quizInstruction($type)
    {
        $userQuizDetail = new QuizInstruction();
        $userId = Auth::user()->id;

        $instruction = $userQuizDetail->where(['type' => $type])
            ->first();
        if ($instruction == null) {
            return $this->error('Access denied', 200);
        }
        return $this->success([['instruction' => $instruction->instruction]]);
    }
    /*----------------------------- youtube Video ----------------------------------------*/
    function youtubeVideo(Request $request)
    {

        $searchString = $request->searchString;
        $data = YoutubeVideo::where(function ($q) use ($searchString) {
            if ($searchString != '') {

                $q->orWhere('title', 'like', '%' . $searchString . '%');
                $date = date('Y-m-d', strtotime($searchString));
                if ($date != "1970-01-01")
                    $q->orWhere('date', $date);
            }
        })
            ->select(
                'id',
                'title',
                'link',
                DB::raw('DATE_FORMAT(date,"%m-%d-%Y") AS new_date')
            )

            ->orderBy('id', 'DESC')
            ->get()
            ->toArray();

        return $this->success(
            $data
        );
    }
    public function autoOTPRead(Request $request)
    {
        $generate_otp = rand(100000, 999999);
        $type='<#> GuruDev Registration/Forgot Password code is : '.$generate_otp.' '.$request->hash_code;
        $result = $this->sendSmsGurudev($type, $request->mobile);
        return $this->success([['otp' => $generate_otp,'hash_code'=>$request->hash_code]]);
    }
}
