<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserRoleDetail extends Model
{
    public $table = 'user_role_details';
    protected $fillable = ['user_role_id','sub_module_id','action_add','action_edit','action_delete'];

    public function subModule(){
        return  $this->belongsTo('App\Models\SubModule')->orderBy('position','DESC');
    }
    public function userRole(){
        return  $this->belongsTo('App\Models\UserRole');
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
