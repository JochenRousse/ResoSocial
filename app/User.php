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

    public function eventRequests()
    {
        return $this->hasMany('App\EventRequest');
    }

    public function friendRequests()
    {
        return $this->hasMany('App\FriendRequest');
    }

    public function friends()
    {
        return $this->belongsToMany('App\User');
    }

    public function createFriendShipWith($id_demandeur)
    {
        return $this->friends()->attach($id_demandeur);
    }

    public function finishFriendshipWith($id_demandeur)
    {
        return $this->friends()->detach($id_demandeur);
    }

    public function isFriendsWith($otherUserId)
    {
        $friends = $this->user_ids;
        return in_array($otherUserId, $friends);
    }

    public function sentFriendRequestTo($otherUserId)
    {
        $friendRequestedByCurrentUser = FriendRequest::where('id_demandeur', $this->id)->where('declined', false)->pluck('user_id')->toArray();
        return in_array($otherUserId, $friendRequestedByCurrentUser);
    }

    public function receivedFriendRequestFrom($otherUserId)
    {
        $friendRequestsReceivedByCurrentUser = FriendRequest::where('user_id', $this->id)->where('declined', false)->pluck('id_demandeur')->toArray();
        return in_array($otherUserId, $friendRequestsReceivedByCurrentUser);
    }

    public function sentEventRequestTo($otherUserId, $idEvent)
    {
        $eventRequestedByCurrentUser = EventRequest::where('user_id', $otherUserId)->where('id_event',$idEvent)->pluck('user_id')->toArray();
        return in_array($otherUserId, $eventRequestedByCurrentUser);
    }

    public function receivedEventRequest($otherUserId)
    {
        $eventRequestsReceivedByCurrentUser = EventRequest::where('id_user', $this->id)->where('declined', false)->pluck('id_event')->toArray();
        return in_array($otherUserId, $eventRequestsReceivedByCurrentUser);
    }

    public function isMemberOfGroup($groupId)
    {
        return Group::where('_id', $groupId)->where('members', $this->id)->where('admin_id', '!=', $this->id)->get()->toArray();
    }

    public function isAdminOfGroup($groupId)
    {
        return Group::where('_id', $groupId)->where('admin_id', $this->id)->get()->toArray();
    }

    public function isAdminOfEvent($eventId)
    {
        return Event::where('_id', $eventId)->where('admin_id', $this->id)->get()->toArray();
    }

    public function isMemberOfEvent($eventId)
    {
        return Event::where('_id', $eventId)->where('members', $this->id)->where('admin_id', '!=', $this->id)->get()->toArray();
    }

    public function isEventOpen($eventId)
    {
        return Event::where('_id', $eventId)->where('close', false)->get()->toArray();
    }
}
