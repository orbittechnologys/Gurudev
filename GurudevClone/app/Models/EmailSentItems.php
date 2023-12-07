<?php

namespace App\Models;

class EmailSentItems extends AppModel
{
    protected $guard = 'email_sent_items';
    protected $fillable = ["user_id", "email", "subject", "details",'attachment'];
    protected $hidden = ['created_at'];

    public function saveData($data){
        $res = $this->create($data);
        if ($res->id > 0){
            return ['success', "Email Sent Successfully"];
        }
        else
            return ['danger', "Invalid Field Details"];
    }
}
