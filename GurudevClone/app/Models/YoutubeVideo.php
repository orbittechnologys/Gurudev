<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;

class YoutubeVideo extends AppModel
{
    protected $guard = 'admin';
    use SoftDeletes;
    protected $fillable = ["title","date", 'link','thumbnail'];
    protected $hidden = [ 'deleted_at', 'created_at', 'updated_at'];
    public function getDateAttribute( $value ) {
        $date=date('d-m-Y',strtotime($value));
       // dd($value);
        return ($date!='01-01-1970')?$date:'-';
    }


    public function saveData($data){
        if (empty($data["id"])) {

            $res = $this->create($data);
            if ($res->id > 0){
                return ['success', "Video Link Saved Successfully"];
            }

            else
                return ['danger', "Invalid Field Details"];
        } else {
            $res = $this->where('id', $data["id"])->update($data);
            if ($res)
                return ['success', "Video Link Updated Successfully"];
            else
                return ['danger', "Invalid Field Details"];
        }
    }
    public function edit($id){
        $current_affairs=$this->find($id);
        return $current_affairs;
    }
}
