<?php

namespace App\Http\Controllers;

use App\Models\Chapter;
use App\Models\Quiz;
use App\Models\QuizDetail;
use App\Models\UserQuizDetail;
use Illuminate\Http\Request;
use App;
use Illuminate\Support\Facades\Route;
use App\Models\Question;
use Carbon\Carbon;
use Illuminate\Support\Facades\Redirect;

use Illuminate\Support\Facades\DB;

class QuizController extends Controller
{

    public function questionsAdd(Request $request)
    {

        if ($request->isMethod('post')) {

            if ($request['id'] != '') {
                $question = new Question();
                $res = $question->updateQuestion($request);
                return redirect()->back()->with($res[0], $res[1]);
            } else {
                $quiz_questions = array();
                for ($i = sizeof($request['question']) - 1; $i >= 0; $i--) {

                    if ($request['question'][$i] != '') {

                        $answer[1] = $request['answer1'][$i];
                        $answer[2] = $request['answer2'][$i];
                        $answer[3] = $request['answer3'][$i];
                        $answer[4] = $request['answer4'][$i];
                        $answer[5] = $request['answer5'][$i];
                        $answer[6] = $request['answer6'][$i];

                        if (empty($request['answer' . $request['correct'][$i]][$i])) {

                            //dd('answer' . $request['correct'][$i]);
                            $answer[$request['correct'][$i]] = "None Of the Above";
                        }
                        $correctAnswer = 'answer' . $request['correct'][$i];

                        array_push($quiz_questions, array(
                            'tags' => $request['tags'],

                            'question' => $request['question'][$i],
                            'answer1' => $answer[1],
                            'answer2' => $answer[2],
                            'answer3' => $answer[3],
                            'answer4' => $answer[4],
                            'answer5' => $answer[5],
                            'answer6' => $answer[6],
                            'description' => $request['description'][$i],
                            'negative_marking' => $request['negative_marking'][$i],
                            'marks' => $request['marks'][$i],
                            'correct_answer' => $correctAnswer,
                            'created_at' => date('Y-m-d H:i:s'),
                            'updated_at' => date('Y-m-d H:i:s')
                        ));
                    }
                }

                $quiz_questions_table = new Question();
                $res = $quiz_questions_table->saveData($quiz_questions);

                return redirect('/admin/questions/list')->with($res[0], $res[1])->with('course', $this->getTags());
            }
        }

        return view('Quiz/questionAdd');
    }
    public function questionEdit(Request $request)
    {
        $table = new Question();
        $result = $table->edit($request->id);
        return response()->json($result);
        // print_r($result);
    }
    public function questionsList($searchString = null)
    {

        if ($searchString) {
            $questions = Question::where(function ($q) use ($searchString) {
                if ($searchString != 'all') {
                    $q->where('question', 'like', '%' . $searchString . '%')
                        ->orWhere('tags', 'like', '%' . $searchString . '%');
                }
            })->orderBy('id', 'desc')
                ->paginate(15)->toArray();
            return view('Quiz/questionsListData')
                ->with('questions', $questions);
        }
        return view('Quiz/questionsList');
    }
    public function dragDrop($searchString = null, $selected_question = null)
    {
        $selected_question = explode(',', $selected_question);
        $questions = Question::where(function ($q) use ($searchString) {
            if ($searchString != 'all') {
                $q->Where('tags', 'like', '%' . $searchString . '%');
            }
        })->whereNotIn('id', $selected_question)->orderBy('id', 'desc')
            ->paginate(150)->toArray();
        //dd($questions);
        return view('Quiz/questionsDragDrop')
            ->with('questions', $questions);
    }

    public function mockTestAdd($crid)
    {
        $chapterDetails = Chapter::where('id', $crid)->first();
        $quizExist = optional(Quiz::where('chapter_id', $crid))->first();

        if ($quizExist != null) {
            return redirect('/admin/quiz/view/' . $quizExist->id);
        }
        //dd($chapterDetails);
        return view('Quiz/adminQuizAdd')
            ->with([
                'times' => $this->getQuizTime(),
                'quiz_type' => '0',
                'backUrl' => url('admin/chapter/list'),
                'cardTitle' => 'Mock Test',
                'chapterDetails' => $chapterDetails
            ]);
    }
    public function currentAffairsQuiz()
    {

        return view('Quiz/adminQuizAdd')
            ->with([
                'times' => $this->getQuizTime(),
                'quiz_type' => '1',
                'backUrl' => url('admin/currentAffairs/list'),
                'cardTitle' => 'Current Affairs MCQ',
            ]);
    }
    public function specialTestAdd()
    {

        return view('Quiz/adminSpcialTestAdd')
            ->with([
                'times' => $this->getQuizTime(),
                'specialTestCourses' => $this->getSpecialTestCourses(),
                'quiz_type' => '2',
                'backUrl' => url('admin/specialTest/test/list'),
                'cardTitle' => 'Special Test',
            ]);
    }
     public function specialTestSave(Request $request)
    {
        if ($request->isMethod('post')) {

            $table = new Quiz();
            $requestData=$request->except('_token');
            //dd($requestData);
            $requestData['publish_date'] = date('Y-m-d', strtotime($requestData['publish_date']));
                $special_test_course_id=$requestData['special_test_course_id'];
               unset($requestData['special_test_course_id']);
            if($requestData['type']==2){
                $requestData['course_id']=$special_test_course_id;

                if( $requestData['subject_id']!=''){
                    $requestData['type']=4;
                }
            }
            if ($requestData['id'] != '') {
                //print_r($request->input()); exit;
                $res = $table->saveData($requestData);
                return redirect()->back()->with($res[0], $res[1]);
            } else {

                $data = explode(',', $requestData['question_id'][0]);
                $questions=[];
                $catCount=[];
                foreach($data as $key=>$val){
                    $qu=explode("_",$val);
                     if(!array_key_exists($qu[0],$questions) && $qu[0]>0 && $qu[1]!='undefined'){
                        $catCount[$qu[1]]++;
                        $questions[$qu[0]]=$qu;
                    }
                }
                $requestData['total_questions']=sizeof($questions);
                $requestData['questions_category_details']=json_encode($catCount);
                $id = $table->saveData($requestData);
                $quiz_questions = array();
                foreach($questions as $val){
                        array_push($quiz_questions, array(
                            'quiz_id' => $id,
                            'question_id' =>$val[0],
                            'category' =>$val[1],
                            'category_time' =>$val[2],
                            'created_at' => date('Y-m-d H:i:s'),
                            'updated_at' => date('Y-m-d H:i:s')
                        ));

                }
               // dd($quiz_questions);
                 $table->where('id',$id)->update(['total_questions'=>sizeof($quiz_questions)]);
                $quiz_questions_table = new QuizDetail();
                $res = $quiz_questions_table->saveData($quiz_questions);
                return redirect('/admin/quiz/view/' . $id)->with($res[0], $res[1]);
            }
        }
    }

     public function quizSave(Request $request)
    {
        if ($request->isMethod('post')) {

            $table = new Quiz();
            $requestData=$request->except('_token');
            $requestData['publish_date'] = date('Y-m-d', strtotime($requestData['publish_date']));
            $special_test_course_id=$requestData['special_test_course_id'];
            unset($requestData['special_test_course_id']);
            if($requestData['type']==2){
                $requestData['course_id']=$special_test_course_id;

                if( $requestData['subject_id']!=''){
                    $requestData['type']=4;
                }
            }
         //   dd($requestData);
            if ($requestData['id'] != '') {
                //print_r($request->input()); exit;
                $res = $table->saveData($requestData);
                return redirect()->back()->with($res[0], $res[1]);
            } else {

                $data = explode(',', $requestData['question_id'][0]);
                $requestData['total_questions']=sizeof($data);

                $id = $table->saveData($requestData);
                $quiz_questions = array();

                for ($i = 0; $i < sizeof($data); $i++) {
                    if ($data[$i] != '') {
                        $question=explode("_",$data[$i]);
                        array_push($quiz_questions, array(
                            'quiz_id' => $id,
                            'question_id' =>$question[0],
                            'category' =>$question[1],
                            'created_at' => date('Y-m-d H:i:s'),
                            'updated_at' => date('Y-m-d H:i:s')
                        ));
                    }
                }
                 $table->where('id',$id)->update(['total_questions'=>sizeof($quiz_questions)]);
                $quiz_questions_table = new QuizDetail();
                $res = $quiz_questions_table->saveData($quiz_questions);
                return redirect('/admin/quiz/view/' . $id)->with($res[0], $res[1]);
            }
        }
    }
    public function quizView(Request $request, $id = null)
    {
        $quiz_details = Quiz::with([
            'course', 'specialCourse', 'subject', 'chapter','stSubCourse',
            'quizDetail.question'
        ])
            ->where(['id' => $id])
            ->first()
            ->toArray();
        $cat_timings=QuizDetail::where('quiz_id',$id)
        ->select("category","category_time",DB::raw('count(*) AS qu_count'))->groupBy('category')->get();
            //dd($cat_timings->toArray());
        if ($quiz_details['type'] == 0)
            $backUrl = url('admin/chapter/list');
        else if ($quiz_details['type'] == 1)
            $backUrl = url('admin/currentAffairs/mcq/list');
        else if ($quiz_details['type'] == 2 || $quiz_details['type'] == 4)
            $backUrl = url('admin/specialTest/test/list');
        //dd($quiz_details);
        return view('Quiz/adminQuizView')
            ->with('quiz_details', $quiz_details)
            ->with('course', $this->getCourse())
            ->with('backUrl', $backUrl) ->with('cat_timings', $cat_timings)
            ->with('times', $this->getQuizTime());
    }
    public function quizList(Request $request)
    {
        $current_route = Route::current()->uri();
        if ($current_route == 'admin/currentAffairs/mcq/list') {
            $type = 'MCQ';
            $conditionType = 1;
            $addUrl = 'admin/currentAffairs/mcq/';
            $cardTitle = "Current Affairs MCQ List";
        } else {
            $type = 'Special-Test';
            $conditionType = 2;
            $conditionType2=4;
            $addUrl = 'admin/specialTest/test';
            $cardTitle = "Special Test List";
        }
        if ($request->searchString != '') {
            $searchString = $request->searchString;
            //dd($request->searchString);
            $quiz_details = Quiz::select(DB::raw('quizzes.*'))
                ->selectRaw(" ( select count(DISTINCT(user_id)) from user_quiz_details where quizzes.id=user_quiz_details.quiz_id ) as attempt_count")
                ->where(function ($q) use ($conditionType,$conditionType2) {
                $q->where('type', $conditionType)
                ->orWhere('type', $conditionType2);
                })
                ->where(function ($q) use ($searchString) {

                    if ($searchString != 'all') {
                        $q->where('quiz_name', 'like', '%' . $searchString . '%');
                        $date = date('Y-m-d', strtotime($searchString));
                        if ($date != "1970-01-01")
                            $q->orWhere('publish_date', $date);
                    }
                })->orderBy('id', 'desc')
                ->paginate(15)->toArray();
            return view('Quiz/adminQuizListData')
                ->with('quiz_details', $quiz_details);
        }


        if ($request->delete_id) {
            $questionAllocation = new Quiz();
            $res = $questionAllocation->deleteWithChild($request->delete_id);
            if ($res) {
                return Redirect::back()->with('success', 'Quiz Deleted Successfully..!');
            } else {
                return Redirect::back()->with('danger', 'Error..!');
            }
        }

        return view('Quiz/adminQuizList')
            ->with('addUrl', $addUrl)
            ->with('current_route', $current_route)
            ->with('cardTitle', $cardTitle);
    }
    public function quizAttendedDetails($id = null)
    {

        $detail_list = UserQuizDetail::with(['user', 'quiz'])
            ->where('quiz_id', $id)
            ->orderByDesc('obtained_marks')
            ->groupBy(['user_id'])
            ->paginate(10);
        //dd($detail_list->total());
        if ($detail_list->total() == 0) {
            return Redirect::back()->with('danger', 'No Students Attended Quiz');
        }
        return view('Quiz/quizAttendedDetails')->with('detail_list', $detail_list);
    }
    function quizDelete(Request $request){
        $row = Quiz::find( $request->id );
        $row->delete();
        return response()->json("success");
    }
}
