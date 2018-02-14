<?php

namespace App\Repositories\Group;

interface GroupRepository
{
    public function getAllGroups($id);

    public function getGroupsAdmin($id);

    public function getIdsMembers($id);
}