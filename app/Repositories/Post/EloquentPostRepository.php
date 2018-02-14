<?php

namespace App\Repositories\Post;

use App\Post;

class EloquentPostRepository implements PostRepository
{

    public function getAllPosts($id)
    {
        return Post::where('user_id', $id)->get()->toArray();
    }

}