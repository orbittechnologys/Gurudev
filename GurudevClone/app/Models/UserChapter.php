<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;

class UserChapter extends AppModel
{
    protected $guard = 'admin';

    public $timestamps=false;
    protected $fillable = ["chapter_id", "purchased", "viewed"];
   


    public function saveData($data){

        if (empty($data["id"])) {

            $res = $this->create($data);
            if ($res->id > 0){
                return 1;
            }

            else
                return 0;
        } else {
            $res = $this->where('id', $data["id"])->update($data);
            if ($res)
                return 1;
            else
                return 0;
        }
    }
    public function edit($id){
        $current_affairs=$this->find($id);
        return $current_affairs;
    }
}
