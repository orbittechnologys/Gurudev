<?php
namespace App\Models;
class Bookmark extends AppModel
{
    protected $fillable = ["user_id", "type", "type_id"];
    public $timestamps=false;

    public function currentAffairs(){
        return  $this->belongsTo(CurrentAffair::class,'type_id');
    }
    public function saveData($data){
        $userId=auth()->user()->id;
        $insertData=[
            "user_id"=>$userId,
            "type" => $data["type"],
            'type_id'=>$data['id']
        ];
        $exist = $this->where($insertData)->exists();

        if(!$exist){
            $res = $this->create($insertData);
            return ['success', "Bookmark Added"];
        }
        else{
            $res=$this->where($insertData)->delete();
            return ['danger', "Removed From Bookmark"];
        }
    }
    public function edit($id){
        $batch=$this->find($id);
        return $batch;
    }
}
