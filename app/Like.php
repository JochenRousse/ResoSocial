<?php

namespace App;

use Jenssegers\Mongodb\Eloquent\SoftDeletes;

class Like extends \Jenssegers\Mongodb\Eloquent\Model
{
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['user_id', 'post_id'];
}
