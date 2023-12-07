<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class QuizDetail extends Model
{


    use SoftDeletes;
    protected $fillable = ["category","quiz_id","question_id","category_time"];
    protected $hidden = [ 'deleted_at', 'created_at', 'updated_at'];

    public function question(){
        return  $this->belongsTo('App\Models\Question');
    }

    public function quiz(){
        return  $this->belongsTo('App\Models\Quiz');
    }
    public function saveData($data){
            $res = $this->insert($data);
            if ($res)
                return ['success',"Questions Added Successfully"];
            else
                return ['danger', "Invalid Field Details"];

    }
}
