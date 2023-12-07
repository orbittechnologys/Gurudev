<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserQuizQuestionDetail extends Model
{



    protected $fillable = ["user_quiz_detail_id","question_id","given_answer","category","mark_review","status","marks","neg_marks"];
    protected $hidden = ['created_at', 'updated_at'];

    public function saveData($data){
        $res = $this->insert($data);
        if ($res)
            return true;
        else
            return false;
    }
    public function question(){
        return  $this->belongsTo('App\Models\Question');
    }
    public function saveMockData($data){
        // print_r($data);

             $exist = $this->where(["user_quiz_detail_id" => $data["user_quiz_detail_id"],"question_id" => $data["question_id"]])->first();

             if (is_null($exist) ) {
                 $res = $this->create($data);
                 return $res->id;
             }else{
             $this->where(["user_quiz_detail_id" => $data["user_quiz_detail_id"],"question_id" => $data["question_id"]])->update($data);
             return $data['id'];
         }
     }
}
