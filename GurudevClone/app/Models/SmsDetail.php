<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SmsDetail extends Model
{
    public $table = 'sms_details';
    protected $guard = 'sms_details';

    protected $fillable = ["user_id","mobile","date","sms_type","status","message"];
    protected $hidden = [ 'created_at', 'updated_at'];

    public  function user(){
        return $this->belongsTo('App\Models\User');
    }

    public function saveData($data){
        $res = SmsDetail::insert($data);
        return ['success', "Message Sent Successfully"];

    }

}
