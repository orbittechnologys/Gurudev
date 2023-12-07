<?php

namespace App\Models;
use Illuminate\Support\Facades\Cache;
class BannerImages extends AppModel
{
    protected $fillable = ["image",'type','url'];
    public $timestamps=false;
    public static function boot()
    {
        parent::boot();
        static::deleting(function($something){
            Cache::forget('BannerImages');
          
        });
    }
    
    public function saveData($data){
        Cache::forget('BannerImages');
        if (empty($data["id"])) {
            $res = $this->insert($data);
            if ($res) {
                return ['success', "Record Added Successfully"];
            } else
                return ['danger', "Invalid Field Details"];
        } else{
            $res = $this->where('id', $data["id"])->update($data);
            return ['success', "Record Updated Successfully"];
        }
    }
    public function edit($id){
        $batch=$this->find($id);
        return $batch;
    }
}
