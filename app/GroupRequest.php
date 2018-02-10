<?php

namespace App;


class GroupRequest extends \Jenssegers\Mongodb\Eloquent\Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['id_demandeur'];

    public function user()
    {
        return $this->belongsTo('App\Group');
    }

    public static function prepareGroupRequest($id_demandeur)
    {
        $GroupRequest = new static(compact('id_demandeur'));

        return $GroupRequest;
    }
}
