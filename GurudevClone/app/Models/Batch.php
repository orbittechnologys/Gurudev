<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

class Batch extends AppModel
{
    protected $guard = 'batches';

    use SoftDeletes;
    protected $fillable = ["batch", "course_id", "user_id"];
    protected $hidden = [ 'deleted_at', 'created_at', 'updated_at'];


    public function saveData($data){
        $data['course_id']=implode(',',$data['course_id']);
        $data['user_id']=implode(',',$data['user_id']);

        if (empty($data["id"])) {
            $res = $this->create($data);
            if ($res->id > 0){
                return ['success', "Batch Created Successfully"];
            }
            else
                return ['danger', "Invalid Field Details"];
        } else {
            $res = $this->where('id', $data["id"])->update($data);
            if ($res)
                return ['success', "Batch Updated Successfully"];
            else
                return ['danger', "Invalid Field Details"];
        }
    }
    public function edit($id){
        $batch=$this->find($id);
        return $batch;
    }
}
