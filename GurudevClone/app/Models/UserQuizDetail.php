<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserQuizDetail extends Model
{

    protected $fillable = ["category_info","last_attended_id","user_id", "quiz_id", "total_time_taken","negative_marks","total_marks","status", "total_question_attended", "correct_answer",'obtained_marks'];
    protected $hidden = ['created_at', 'updated_at'];

    public function quiz(){
        return $this->belongsTo(Quiz::class);
    }
    public function User(){
        return $this->belongsTo(User::class);
    }
    public function userQuizQuestionDetail(){
        return $this->hasMany(UserQuizQuestionDetail::class);
    }

    public function saveData($data){
        if(empty($data['id'])){
            $res = $this->create($data);
            return $res->id;
        }else{
            $this->where('id', $data["id"])->update($data);
            return $data['id'];
        }
    }
    public function saveSpecialTestData($data){
        $exist = $this->where(["quiz_id" => $data["quiz_id"],"user_id" => $data["user_id"]])->first();

             if (is_null($exist) ) {
                 $res = $this->create($data);
                 return $res->id;
             }else{
                $id=$data['id'];unset($data['id']);
                $this->where(["quiz_id" => $data["quiz_id"],"user_id" => $data["user_id"]])->update($data);
                return $data['id'];
             }
    }
}
