<?php

namespace App\Repositories\Group;

use App\Group;

class EloquentGroupRepository implements GroupRepository
{
    public function getAllGroups($id)
    {
        return Group::where('members', $id)->where('admin_id', '!=', $id)->get()->toArray();
    }

    public function getGroupsAdmin($id)
    {
        return Group::where('admin_id', $id)->get()->toArray();
    }
}