<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ModuleDetail extends Model
{
    public $table = 'module_details';
	use SoftDeletes;
    protected $fillable = ['module_name','icon_name','status','position'];
    public function subModule(){
        return  $this->hasMany('App\Models\SubModule');
    }
    public function userRole(){
        return  $this->hasMany('App\Models\UserRole');
    }
	public function saveData($requestData)
    {
        $res = $this->create($requestData);
        if ($res->id > 0)
            return ['success', "Main Menu Added Successfully",$res->id];
        else
            return ['danger', "Invalid Field Details"];

    }
}
