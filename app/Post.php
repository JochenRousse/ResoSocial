<?php
namespace App;

use App\Like;

class Post extends \Jenssegers\Mongodb\Eloquent\Model {

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['type', 'path', 'message'];

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public static function preparePost($type, $path = null, $message = null)
    {
        if(isset($path)){
            $FriendRequest = new static(compact('type', 'path'));
        } else{
            $FriendRequest = new static(compact('type', 'message'));
        }

        return $FriendRequest;
    }
}
