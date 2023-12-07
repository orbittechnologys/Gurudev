<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

class SpecialTestCourse extends AppModel
{
    protected $guard = 'admin';
    use SoftDeletes;
    protected $fillable = [ "course", "slug", "status", "type", "amount"];
    protected $hidden = [ 'deleted_at', 'created_at', 'updated_at'];

    public function payment(){
        return  $this->hasOne(PaymentDetail::class,'type_id')->where('type','SpecialTestCourse')->where('user_id',Auth::user()->id);
    }
    public function quizCount(){
        return  $this->hasOne(Quiz::class,'course_id')->where('type',2)->orWhere('type',4);
    }
    public function saveData($data){
        $slug = AppModel::slug($data['course']);
        $count = static::whereRaw("slug RLIKE '^{$slug}(-[0-9]+)?$'")->count();
        $data['slug'] = $count ? "{$slug}-{$count}" : $slug;
        if (empty($data["id"])) {

            $res = $this->create($data);
            if ($res->id > 0){
                return ['success', "Special Test Course Created Successfully"];
            }

            else
                return ['danger', "Invalid Field Details"];
        } else {
            $res = $this->where('id', $data["id"])->update($data);
            if ($res)
                return ['success', "Special Test Course Updated Successfully"];
            else
                return ['danger', "Invalid Field Details"];
        }
    }
    public function edit($id){
        $current_affairs=$this->find($id);
        return $current_affairs;
    }
}
