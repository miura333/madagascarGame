<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class anonymousUserModel extends Model
{
    protected $table = 'anonymous_users';

    protected $fillable = [
        'id',
        'user_id',
        'user_name'
    ];
}
