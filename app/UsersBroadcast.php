<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UsersBroadcast extends Model
{
    protected $fillable =
    [
        'user_id',
        'broadcast_id'
    ];
}
