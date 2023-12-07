<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Cache;
class Quiz extends Model
{

    use SoftDeletes;
    protected $fillable = ["course_id","subject_id","chapter_id","type","quiz_name","publish_date","total_time","status","total_questions","description","start_date_time","questions_category_details"];
    protected $hidden = [ 'deleted_at', 'created_at', 'updated_at'];
    public function quizDetail(){
        return  $this->hasMany('App\Models\QuizDetail')->orderBy('category')->orderBy('question_id');
    }
    public static function boot()
    {
        parent::boot();
        static::deleting(function($something){
            Cache::forget('mcqQuiz');
          
        });
    }

    public function course(){
        return  $this->belongsTo('App\Models\Course');
    }
    public function specialCourse(){
        return  $this->belongsTo(SpecialTestCourse::class,'course_id');
    }
    public function subject(){
        return  $this->belongsTo('App\Models\Subject');
    }public function chapter(){
        return  $this->belongsTo('App\Models\Chapter');
    }

    public function userQuizDetail(){
        return  $this->hasOne('App\Models\UserQuizDetail');
    }
    public function userQuizDetails(){
        return  $this->hasMany('App\Models\UserQuizDetail');
    }
    public function stSubCourse(){
        return  $this->belongsTo(SpecialTestSubCourse::class,'subject_id');
    }

    public function saveData($data){
        Cache::forget('mcqQuiz');
         if($data['start_time']){
                $data["start_date_time"]=date('Y-m-d H:i',strtotime($data['publish_date']." ".$data['start_time']));
                unset($data['start_time']);
            }
        if (empty($data["id"])) {
            $res = $this->create($data);
            if ($res->id > 0)
                return $res->id;
            else
                return ['danger', "Invalid Field Details"];
        } else {
            $res = $this->where('id', $data["id"])->update($data);
            if ($res)
                return ['success', $data['type']." Updated Successfully"];
            else
                return ['danger', "Invalid Field Details"];
        }
    }
    public function edit($id){
        $data=$this->find($id);
        return $data;
    }
    public function updateQuizDetails($data){

        if($data['start_time']){
            $data["start_date_time"]=date('Y-m-d H:i',strtotime($data['publish_date']." ".$data['start_time']));
            unset($data['start_time']);
        }
        else{
            $data["start_date_time"]=null;
        }
        $this->where('id',$data['id'])
            ->update(["start_date_time"=> $data["start_date_time"],'course_id' => $data['course_id'],'quiz_name'=>$data['quiz_name'],'publish_date'=>$data['publish_date'],'total_time'=>$data['total_time'],'status'=>$data['status'],'description'=>$data['description']]);

        return ['success', $data['type']." Updated Successfully"];
    }
    public function deleteWithChild($id){
        $quiz = $this->find($id);
        $quiz->quizDetail()->delete();

        $res = $quiz->delete();
        if ($res)
            return ['success', "Deleted Successfully"];
        else
            return ['danger', "Error"];
    }

}
