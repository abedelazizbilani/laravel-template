<?php

namespace App\Repositories;

use App\Models\Feedbacks;

class FeedBacksRepository
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
        return Feedbacks::orderBy($parameters['order'], $parameters['direction'])
            ->get();
    }
}
