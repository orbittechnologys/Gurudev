<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserRole extends Model
{
    public $table = 'user_roles';
    public $timestamps=false;
    protected $fillable = ['staff_id','module_detail_id'];

	public function saveData($requestData)
    {
        $res = $this->create($requestData);
        if ($res->id > 0)
            return ['success', "Main Menu Added Successfully",$res->id];
        else
            return ['danger', "Invalid Field Details"];

    }

    public function moduleDetail(){
        return  $this->belongsTo('App\Models\ModuleDetail');
    }
    public function userRoleDetail(){
        return  $this->hasMany('App\Models\UserRoleDetail');
    }
    public static function boot()
    {
        parent::boot();

        static::deleting(function($q)
        {
            dd($q);
           // $q->userRoleDetail()->delete();
        });
    }
}
