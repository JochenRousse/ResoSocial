<?php namespace App\Repositories\User;

use App\User;

interface UserRepository
{	
	public function findManyById(array $ids);
	public function findByIdWithFriends($userId);
}