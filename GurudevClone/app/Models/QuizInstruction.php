<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

class QuizInstruction extends AppModel
{
    protected $guard = 'batches';
    protected $fillable = ["type", "instruction"];
    public $timestamps = false;
}
