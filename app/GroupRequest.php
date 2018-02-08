<?php

namespace App;


class GroupRequest extends \Jenssegers\Mongodb\Eloquent\Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['group_id', 'id_demandeur'];

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public static function prepareGroupRequest($id_demandeur, $group_id)
    {
        $GroupRequest = new static(compact('id_demandeur', 'group_id'));

        return $GroupRequest;
    }
}
