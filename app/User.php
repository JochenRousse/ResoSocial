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
    protected $fillable = ['username', 'password', 'nom', 'prenom', 'ddn', 'genre', 'email', 'annee', 'filiere'];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * A user can have many friend requests.
     *
     * @return collection
     */
    public function friendRequests()
    {
        return $this->hasMany('App\FriendRequest');
    }

    /**
     * A user can have many friends.
     *
     * @return collection
     *
     */
    public function friends()
    {
        return $this->belongsToMany(Self::class, 'friends', 'id_demandé', 'id_demandeur')->withTimestamps();
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
        $friend = new Friend(['id_demandé' => $this->id, 'id_demandeur' => $id_demandeur]);
        $this->friends()->attach($friend);

        return $this->save();

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
        return $this->friends()->detach($id_demandeur, ['id_demandé' => $this->id, 'id_demandeur' => $id_demandeur]);
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
        $currentUserFriends = Friend::where('id_demandeur', $this->id)->pluck('id_demandé')->toArray();

        return in_array($otherUserId, $currentUserFriends);
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
        $friendRequestedByCurrentUser = FriendRequest::where('id_demandeur', $this->id)->pluck('user_id')->toArray();

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
        $friendRequestsReceivedByCurrentUser = FriendRequest::where('user_id', $this->id)->pluck('id_demandeur')->toArray();

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
