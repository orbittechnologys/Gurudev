<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SubModule extends Model
{
    public $table = 'sub_modules';
    use SoftDeletes;
    protected $fillable = ['module_detail_id','sub_module_name','url','position','is_default','level','under'];
    public function userRoleDetail(){
        return  $this->hasMany('App\Models\UserRoleDetail');
    }
    public function MainMenu()
    {
        return  $this->belongsTo('App\Models\ModuleDetail','module_detail_id')->select(['id','module_name']);
    }
    public function SubMenuUnder()
    {
        return $this->belongsTo('App\Models\SubModule','under')->select(['id','sub_module_name']);
    }
    public function saveData($requestData)
    {
        $res = $this->create($requestData);
        if ($res->id > 0)
            return ['success', "Sub Menu Added Successfully",$res->id];
        else
            return ['danger', "Invalid Field Details"];

    }
}
