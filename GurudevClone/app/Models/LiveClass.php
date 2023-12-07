<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class LiveClass extends Model
{
    protected $fillable = ["batch_id","title","description","start_time","duration","status","meeting_id","password",'end_time'];
    protected $hidden = [ 'created_at','updated_at','deleted_at'];


    public function batch(){
        return  $this->belongsTo('App\Models\Batch');
    }

    public function saveData($data){

        $duration= date('h:i',strtotime($data['duration']));
        $data['start_time']= date('Y-m-d H:i',strtotime($data['class_date'] . " " . $data['start_time']));
        $data['end_time']=date('Y-m-d H:i',strtotime('+'.date('h',strtotime($duration)).' hour +'.date('i',strtotime($duration)).' minutes',strtotime($data['start_time'])));

        unset($data['class_date']);
        if (empty($data["id"])) {

            $res = $this->create($data);
            if ($res->id > 0)
                return ['success', "Live Class Created Successfully"];
            else
                return ['danger', "Invalid Field Details"];
        } else {
            $res =  $this->where('id', $data["id"])->update($data);
            if ($res)
                return ['success', "Live Class Updated Successfully"];
            else
                return ['danger', "Invalid Field Details"];
        }
    }
    public function edit($id){
        $data=$this->find($id);
        $data->class_date=date('d-m-Y',strtotime($data['start_time']));
        $data->start_time=date('h:i A',strtotime($data['start_time']));
        return $data;
    }
}
