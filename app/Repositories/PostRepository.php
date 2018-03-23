<?php

namespace App\Repositories;

use App\Models\Post;

class PostRepository
{
    /**
     * Get roles collection paginate.
     *
     * @param  int $nbrPages
     * @param  array $parameters
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function getAll($parameters)
    {
        return Post::orderBy($parameters['order'], $parameters['direction'])
            ->get();
    }
}
