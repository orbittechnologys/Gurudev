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
                $q->where('question', 'like', '%' . $searchString . '%')
                    ->orWhere('tags', 'like', '%' . $searchString . '%');
            }
        })->whereNotIn('id', $selected_question)->orderBy('id', 'desc')
            ->paginate(400)->toArray();
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

        return view('Quiz/adminQuizAdd')
            ->with([
                'times' => $this->getQuizTime(),
                'specialTestCourses' => $this->getSpecialTestCourses(),
                'quiz_type' => '2',
                'backUrl' => url('admin/specialTest/test/list'),
                'cardTitle' => 'Special Test',
            ]);
    }

    public function quizSave(Request $request)
    {
        if ($request->isMethod('post')) {

            $table = new Quiz();
            $request['publish_date'] = date('Y-m-d', strtotime($request['publish_date']));

            if ($request['id'] != '') {
                //print_r($request->input()); exit;
                $res = $table->saveData($request->except('_token'));
                return redirect()->back()->with($res[0], $res[1]);
            } else {
                
                $data = explode(',', $request['question_id'][0]);
                $requestData=$request->except('_token');
                $requestData['total_questions']=sizeof($data);
                //dd($requestData);
                $id = $table->saveData($request->except('_token'));
                $quiz_questions = array();
                
                for ($i = 0; $i < sizeof($data); $i++) {
                    if ($data[$i] != '') {
                        array_push($quiz_questions, array(
                            'quiz_id' => $id,
                            'question_id' => $data[$i],
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
            'course', 'specialCourse', 'subject', 'chapter',
            'quizDetail.question' 
        ])
            ->where(['id' => $id])
            ->first()
            ->toArray();
       
        if ($quiz_details['type'] == 0)
            $backUrl = url('admin/chapter/list');
        else if ($quiz_details['type'] == 1)
            $backUrl = url('admin/currentAffairs/mcq/list');
        else if ($quiz_details['type'] == 2)
            $backUrl = url('admin/specialTest/test/list');
        //dd($quiz_details);
        return view('Quiz/adminQuizView')
            ->with('quiz_details', $quiz_details)
            ->with('course', $this->getCourse())
            ->with('backUrl', $backUrl)
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
            $addUrl = 'admin/specialTest/test';
            $cardTitle = "Special Test List";
        }
        if ($request->searchString != '') {
            $searchString = $request->searchString;
            //dd($request->searchString);
            $quiz_details = Quiz::select(DB::raw('quizzes.*'))
                ->selectRaw(" ( select count(DISTINCT(user_id)) from user_quiz_details where quizzes.id=user_quiz_details.quiz_id ) as attempt_count")
                ->where('type', $conditionType)
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
