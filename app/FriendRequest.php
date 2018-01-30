<?php
namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Auth\Authenticatable;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;

class FriendRequest extends \Jenssegers\Mongodb\Eloquent\Model implements
    AuthenticatableContract,
    AuthorizableContract,
    CanResetPasswordContract
{
    use Authenticatable, Authorizable, CanResetPassword, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['id_demandeur'];


    /**
     * A feed belongs to a User.
     *
     * @return User
     */
    public function user()
    {
        return $this->belongsTo('App\User');
    }


    /**
     * Send a friend request to a user
     *
     *
     * @attr int $id_demandeur
     *
     */
    public static function prepareFriendRequest($id_demandeur)
    {
        $FriendRequest = new static(compact('id_demandeur'));

        return $FriendRequest;
    }

}
