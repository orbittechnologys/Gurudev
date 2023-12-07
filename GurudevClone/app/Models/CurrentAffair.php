<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Cache;
class CurrentAffair extends AppModel
{
    public $table = 'current_affairs';
    protected $guard = 'admin';

    use SoftDeletes;
    protected $fillable = ["title", "slug", "date", "tags", "source", "description", "image",];
    protected $hidden = [ 'deleted_at', 'created_at', 'updated_at'];

    protected $appends = ['tag_array','App_URL','clear_description'];
    public static function boot()
    {
        parent::boot();
        static::deleting(function($something){
            Cache::forget('CurrentAffair');
          
        });
    }
    public function bookmark(){
        return  $this->hasOne('App\Models\Bookmark','type_id')->where(['type'=>'CurrentAffairs']);;
    }
    public function getDateAttribute( $value ) {
        $date=date('d-m-Y',strtotime($value));
       // dd($value);
        return ($date!='01-01-1970')?$date:'-';
    }
    public function getTagArrayAttribute()
    {
        return $this->tags!='' ? explode(',',$this->tags) : null;
    }
     public function getAppURLAttribute()
    {
        return env('MOBILEAPP_URL');
    }
     public function getClearDescriptionAttribute()
    {
        $plainText = trim(preg_replace('/\s\s+/', ' ', strip_tags($this->description)));
        return html_entity_decode ($plainText);
    }
    public function saveData($data){
        Cache::forget('CurrentAffair');
        $slug = AppModel::slug($data['title']);
        $count = static::where("slug", 'like', '%' . $slug . '%')->count();
        $data['slug'] = $count ? "{$slug}-{$count}" : $slug;
        if (empty($data["id"])) {

            $res = $this->create($data);
            if ($res->id > 0){
                return ['success', "Current Affairs Created Successfully"];
            }

            else
                return ['danger', "Invalid Field Details"];
        } else {
            $res = $this->where('id', $data["id"])->update($data);
            if ($res)
                return ['success', "Current Affairs Updated Successfully"];
            else
                return ['danger', "Invalid Field Details"];
        }
    }
    public function edit($id){
        $current_affairs=$this->find($id);
        return $current_affairs;
    }
}
