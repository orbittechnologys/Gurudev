<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

class WeeklyBuzzFolder extends AppModel
{
    protected $guard = 'admin';

    use SoftDeletes;
    public $timestamps=false;
    protected $fillable = ["folder_name"];
    protected $hidden = [ 'deleted_at'];

}
