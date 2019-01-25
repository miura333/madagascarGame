<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class scoreModel extends Model
{
    protected $table = 'score';

    protected $fillable = [
        'id',
        'user_id',
        'country_code',
        'score'
    ];
}
