<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

class SpecialTestSubCourse extends AppModel
{
    protected $guard = 'admin';
    use SoftDeletes;
    protected $fillable = [ "special_test_course_id","title","type", "amount"];
    protected $hidden = [ 'deleted_at', 'created_at', 'updated_at'];

    public function payment(){
        return  $this->hasOne(PaymentDetail::class,'type_id')->where('type','SpecialTestSubCourse')->where('user_id',Auth::user()->id);
    }
    public function quizCount(){
        return  $this->hasOne(Quiz::class,'subject_id')->where('type',4);
    }
    public function course(){
        return  $this->belongsTo(SpecialTestCourse::class,'special_test_course_id');
    }
    public function saveData($data){

        if (empty($data["id"])) {

            $res = $this->create($data);
            if ($res->id > 0){
                return ['success', "Special Test Sub Course Created Successfully"];
            }

            else
                return ['danger', "Invalid Field Details"];
        } else {
            $res = $this->where('id', $data["id"])->update($data);
            if ($res)
                return ['success', "Special Test Sub Course Updated Successfully"];
            else
                return ['danger', "Invalid Field Details"];
        }
    }
    public function edit($id){
        $current_affairs=$this->find($id);
        return $current_affairs;
    }
}
