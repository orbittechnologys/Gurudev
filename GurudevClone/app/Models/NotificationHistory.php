<?php

namespace App\Models;

class NotificationHistory extends AppModel
{
     public $timestamps = false;
   protected $fillable=["user_id", "notification_id", "read_at"];
}
