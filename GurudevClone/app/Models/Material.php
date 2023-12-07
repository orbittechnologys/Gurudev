<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Notification;
use App\Notifications\SendPushNotification;
use Illuminate\Support\Facades\Cache;
class Material extends AppModel
{
    protected $guard = 'admin';

    use SoftDeletes;
    protected $fillable = ["type","title", "date", "tags",'thumbnail',"material",'for_dashboard','youtube_url'];
    protected $hidden = [ 'deleted_at', 'created_at', 'updated_at'];
    protected $appends = ['tag_array'];
    public static function boot()
    {
        parent::boot();
        static::deleting(function($something){
            Cache::forget('Material');
          
        });
    }
    public function getDateAttribute( $value ) {
        $date=date('d-m-Y',strtotime($value));
       // dd($value);
        return ($date!='01-01-1970')?$date:'-';
    }
    public function getTagArrayAttribute()
    {
        return $this->tags!='' ? explode(',',$this->tags) : null;
    }
    public function saveData($data){
        Cache::forget('Material');
        $data['for_dashboard']=isset($data['for_dashboard']) ? 1 : 0;
        if (empty($data["id"])) {
            $title="New Study Material Uploaded on ".date('d-m-Y',strtotime($data['date']));
            $description=$data['title'];
            Notification::send(null,new SendPushNotification($title,$description,'Material'));

            $res = $this->create($data);
            if ($res->id > 0){
                return ['success', "Material Saved Successfully"];
            }

            else
                return ['danger', "Invalid Field Details"];
        } else {
            $res = $this->where('id', $data["id"])->update($data);
            if ($res)
                return ['success', "Material Updated Successfully"];
            else
                return ['danger', "Invalid Field Details"];
        }
    }
    public function edit($id){
        $current_affairs=$this->find($id);
        return $current_affairs;
    }
}
