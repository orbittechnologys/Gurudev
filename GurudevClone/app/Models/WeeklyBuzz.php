<?php

namespace App\Models;
use Notification;
use App\Notifications\SendPushNotification;
use Illuminate\Database\Eloquent\SoftDeletes;

class WeeklyBuzz extends AppModel
{
    protected $guard = 'admin';
    use SoftDeletes;
    protected $fillable = ["weekly_buzz_folder_id","title","date", 'attachment','thumbnail'];
    protected $hidden = [ 'deleted_at', 'created_at', 'updated_at'];
    public function getDateAttribute( $value ) {
        $date=date('d-m-Y',strtotime($value));
       // dd($value);
        return ($date!='01-01-1970')?$date:'-';
    }

    public function weeklyBuzzFolder(){
        return  $this->belongsTo('App\Models\WeeklyBuzzFolder');
    }

    public function saveData($data){
        if (empty($data["id"])) {
            $title='E Magazine of '.$data['title'];
            $description="New Magazine Uploaded on ".date('d-m-Y',strtotime($data['date']));
            Notification::send(null,new SendPushNotification($title,$description,'WeeklyBuzz/'.$data['weekly_buzz_folder_id']));

            $res = $this->create($data);
            if ($res->id > 0){
                return ['success', "Weekly Buzz Created Successfully"];
            }

            else
                return ['danger', "Invalid Field Details"];
        } else {
           // dd($data);
            $res = $this->where('id', $data["id"])->update($data);
            if ($res)
                return ['success', "Weekly Buzz Updated Successfully"];
            else
                return ['danger', "Invalid Field Details"];
        }
    }
    public function edit($id){
        $current_affairs=$this->find($id);
        return $current_affairs;
    }
}
