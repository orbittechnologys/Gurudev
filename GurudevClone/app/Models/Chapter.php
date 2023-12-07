<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

class Chapter extends AppModel
{
    protected $guard = 'admin';

    use SoftDeletes;
    protected $fillable = ["course_id", "subject_id", "chapter", "date", "slug", "status", "type", "amount","material","video_material", "description",];
    protected $hidden = [ 'deleted_at', 'created_at', 'updated_at'];
    public function getDateAttribute( $value ) {
        $date=date('d-m-Y',strtotime($value));
        // dd($value);
        return ($date!='01-01-1970')?$date:'-';
    }
    public function course(){
        return  $this->belongsTo(Course::class)->select(['id','course','slug']);
    }
    public function subject(){
        return  $this->belongsTo(Subject::class)->select(['id','subject','slug']);
    }
    public function user_chapter(){
        return  $this->hasOne(UserChapter::class);
    }
    public function payment(){
        return  $this->hasOne(PaymentDetail::class,'type_id')->where('type','Chapter')->where('user_id',Auth::user()->id);
    }
    public function saveData($data){
        $slug = AppModel::slug($data['chapter']);
        $count = static::whereRaw("slug RLIKE '^{$slug}(-[0-9]+)?$'")->count();
        $data['slug'] = $count ? "{$slug}-{$count}" : $slug;
        if (empty($data["id"])) {

            $res = $this->create($data);
            if ($res->id > 0){
                return ['success', "Chapter Created Successfully"];
            }

            else
                return ['danger', "Invalid Field Details"];
        } else {
            $res = $this->where('id', $data["id"])->update($data);
            if ($res)
                return ['success', "Chapter Updated Successfully"];
            else
                return ['danger', "Invalid Field Details"];
        }
    }
    public function edit($id){
        $current_affairs=$this->find($id);
        return $current_affairs;
    }
}
