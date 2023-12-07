<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class LiveClassAttendedUsers extends Model{
    protected $fillable = ["user_id","live_class_id","login"];
    public  $timestamps=false;
    public function user(){
        return  $this->belongsTo(User::class);
    }
    public function saveData($data){
        $exist = $this->where([["user_id", $data["user_id"]], "live_class_id" => $data["live_class_id"]])->first();
        if (!is_null($exist) && $exist->exists) {
            $res= $this->where([["user_id", $data["user_id"]], "live_class_id" => $data["live_class_id"]])
                ->update(['login'=>$data['login']]);
        }
        else{
            $res = $this->create($data);
        }
    }
}
