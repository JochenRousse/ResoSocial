<?php

namespace App\Repositories\User;

interface UserRepository
{	
	public function findManyById(array $ids);
	public function findByIdWithFriends($userId);
}