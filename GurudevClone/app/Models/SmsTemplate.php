<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;

class SmsTemplate extends AppModel
{

    protected $fillable = ["title", "template","sender"];
    public $timestamps=false;
    public function saveData($data){
        if (empty($data["id"])) {
            $res = $this->create($data);
            if ($res->id > 0){
                return ['success', "Template Created Successfully"];
            }
            else
                return ['danger', "Invalid Field Details"];
        } else {
            $res = $this->where('id', $data["id"])->update($data);
            if ($res)
                return ['success', "Template Updated Successfully"];
            else
                return ['danger', "Invalid Field Details"];
        }
    }
    public function edit($id){
        $current_affairs=$this->find($id);
        return $current_affairs;
    }
}
