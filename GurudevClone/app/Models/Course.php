<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;
use Notification;
use App\Notifications\SendPushNotification;
use Illuminate\Support\Facades\Cache;
class Course extends AppModel
{
    protected $guard = 'admin';

    use SoftDeletes;
    protected $fillable = ["course", "slug", "course_type", "amount", "discount","final_amount", "description", "background_image"];
    protected $hidden = [ 'deleted_at', 'created_at', 'updated_at'];
    public static function boot()
    {
        parent::boot();
        static::deleting(function($something){
            Cache::forget('Course');
          
        });
    }
    public function payment(){
        return  $this->hasOne(PaymentDetail::class,'type_id')->where('type','Course')->where('user_id',Auth::user()->id);
    }
      public function selected(){
        return  $this->hasOne(PaymentDetail::class,'type_id')->where('type','Course')->where('user_id',Auth::user()->id);
    }
    public function saveData($data){
        Cache::forget('Course');
        $slug = AppModel::slug($data['course']);
        $count = static::whereRaw("slug RLIKE '^{$slug}(-[0-9]+)?$'")->count();
        $data['slug'] = $count ? "{$slug}-{$count}" : $slug;
        if (empty($data["id"])) {
             $title="New Course Uploaded on ".date('d-m-Y');
            $description=$data['course'];
            Notification::send(null,new SendPushNotification($title,$description,'Course'));

            $res = $this->create($data);
            if ($res->id > 0){
                return ['success', "Course Created Successfully"];
            }

            else
                return ['danger', "Invalid Field Details"];
        } else {
            $res = $this->where('id', $data["id"])->update($data);
            if ($res)
                return ['success', "Course Updated Successfully"];
            else
                return ['danger', "Invalid Field Details"];
        }
    }
    public function edit($id){
        $current_affairs=$this->find($id);
        return $current_affairs;
    }
}
