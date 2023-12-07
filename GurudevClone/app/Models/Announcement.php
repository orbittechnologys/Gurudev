<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Notification;
use App\Notifications\SendPushNotification;
use Illuminate\Support\Facades\Cache;
class Announcement extends AppModel
{
    protected $guard = 'admin';
    use SoftDeletes;
    protected $fillable = ["title", "slug", "date", "description",'attachment','pdf','url'];
    protected $hidden = [ 'deleted_at', 'created_at', 'updated_at'];
    public function getDateAttribute( $value ) {
        $date=date('d-m-Y',strtotime($value));
       // dd($value);
        return ($date!='01-01-1970')?$date:'-';
    }
    public static function boot()
    {
        parent::boot();
        static::deleting(function($something){
            Cache::forget('Announcement');
          
        });
    }
    public function history(){
        return  $this->hasOne('App\Models\NotificationHistory','notification_id');
    }
    public function saveData($data){
        Cache::forget('Announcement');
        $slug = AppModel::slug($data['title']);
        $count = static::whereRaw("slug RLIKE '^{$slug}(-[0-9]+)?$'")->count();
        $data['slug'] = $count ? "{$slug}-{$count}" : $slug;
        if (empty($data["id"])) {


    Notification::send(null,new SendPushNotification($data['title'],$data['description'],'Notification'));
            $res = $this->create($data);
            if ($res->id > 0){
                return ['success', "Announcements Created Successfully"];
            }

            else
                return ['danger', "Invalid Field Details"];
        } else {
            $res = $this->where('id', $data["id"])->update($data);
            if ($res)
                return ['success', "Announcements Updated Successfully"];
            else
                return ['danger', "Invalid Field Details"];
        }
    }
    public function edit($id){
        $current_affairs=$this->find($id);
        return $current_affairs;
    }
}
