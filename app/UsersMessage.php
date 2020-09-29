<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class UsersMessage extends Model
{
    public const SECRET = "QUes6qN";

    protected $fillable =
        [
          'user_id',
          'message',
          'broadcast_id'
        ];

}
