<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

class PaymentDetail extends Model{


    public $timestamps=false;
    protected $fillable=["user_id", "order_id", "type","type_id", "payment_id", "amount", "status", "payment_method", "payment_date"];

    public function user(){
        return  $this->belongsTo(User::class);
    }  public function course(){
        return  $this->belongsTo(Course::class,'type_id');
    }    public function specialCourse(){
        return  $this->belongsTo(SpecialTestCourse::class,'type_id');
    }
}
