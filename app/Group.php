<?php

namespace App;

class Group extends \Jenssegers\Mongodb\Eloquent\Model {

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'admin_id', 'members', 'statut', 'pending'];
}
