<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

class Subject extends AppModel
{
    protected $guard = 'admin';

    use SoftDeletes;
    protected $fillable = ["course_id", "slug", "type", "amount", "subject"];
    protected $hidden = [ 'deleted_at', 'created_at', 'updated_at'];
    public function course(){
        return  $this->belongsTo(Course::class)->select(['id','course','slug']);
    }
    public function payment(){
        return  $this->hasOne(PaymentDetail::class,'type_id')->where('type','Subject')->where('user_id',Auth::user()->id);
    } public function chapterCount(){
        return  $this->hasOne(Chapter::class);
    }public function quizCount(){
        return  $this->hasOne(Quiz::class);
    }
    public function saveData($data){
        $slug = AppModel::slug($data['subject']);
        $count = static::whereRaw("slug RLIKE '^{$slug}(-[0-9]+)?$'")->count();
        $data['slug'] = $count ? "{$slug}-{$count}" : $slug;
        if (empty($data["id"])) {

            $res = $this->create($data);
            if ($res->id > 0){
                return ['success', "Subject Created Successfully"];
            }

            else
                return ['danger', "Invalid Field Details"];
        } else {
            $res = $this->where('id', $data["id"])->update($data);
            if ($res)
                return ['success', "Subject Updated Successfully"];
            else
                return ['danger', "Invalid Field Details"];
        }
    }
    public function edit($id){
        $current_affairs=$this->find($id);
        return $current_affairs;
    }
}
