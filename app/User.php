<?php
namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Auth\Authenticatable;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Jenssegers\Mongodb\Eloquent\Model;

class User extends Model implements
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
    protected $fillable = ['username', 'password', 'nom', 'prenom', 'ddn', 'genre', 'email', 'annee', 'filiere', 'user_ids'];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function friendRequests()
    {
        return $this->hasMany('App\FriendRequest');
    }

    public function friends()
    {
        return $this->belongsToMany('App\User');
    }

    /**
     * Add a friend to a user.
     *
     * @param int $id_demandeur
     *
     * @return mixed
     */
    public function createFriendShipWith($id_demandeur)
    {
        return $this->friends()->attach($id_demandeur);

    }

    /**
     * Remove a friend from a user.
     *
     * @param int $id_demandeur
     *
     * @return mixed
     */
    public function finishFriendshipWith($id_demandeur)
    {
        return $this->friends()->detach($id_demandeur);
    }

    /**
     * Determine if current user is friends with another user.
     *
     * @param int $otherUserId
     *
     * @return boolean
     */
    public function isFriendsWith($otherUserId)
    {
        $friends = $this->user_ids;
        return in_array($otherUserId, $friends);
    }

    /**
     * Determine if current user has sent a friend request to another user.
     *
     * @param int $otherUserId
     *
     * @return boolean
     */
    public function sentFriendRequestTo($otherUserId)
    {
        $friendRequestedByCurrentUser = FriendRequest::where('id_demandeur', $this->id)->where('declined', false)->pluck('user_id')->toArray();

        return in_array($otherUserId, $friendRequestedByCurrentUser);
    }

    /**
     * Determine if current user has received a friend request from another user.
     *
     * @param int $otherUserId
     *
     * @return boolean
     */
    public function receivedFriendRequestFrom($otherUserId)
    {
        $friendRequestsReceivedByCurrentUser = FriendRequest::where('user_id', $this->id)->where('declined', false)->pluck('id_demandeur')->toArray();

        return in_array($otherUserId, $friendRequestsReceivedByCurrentUser);
    }


    /**
     * Determine if the current user is the same as the given one.
     *
     * @param int $id
     *
     * @return boolean
     *
     */
    public function is($id)
    {
        return $this->id == $id;
    }
}
