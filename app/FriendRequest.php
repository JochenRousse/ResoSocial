<?php
namespace App;

class FriendRequest extends \Jenssegers\Mongodb\Eloquent\Model {

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['id_demandeur', 'declined', 'accepted'];

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public static function prepareFriendRequest($id_demandeur)
    {
        $declined = false;
        $accepted = false;
        $FriendRequest = new static(compact('id_demandeur', 'declined', 'accepted'));

        return $FriendRequest;
    }

}
