<?php

namespace App\Repositories;

use App\Models\Devices;

class DevicesRepository
{
    /**
     * Get devices collection paginate.
     *
     * @param  int $nbrPages
     * @param  array $parameters
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function getAll($parameters)
    {
        return Devices::orderBy($parameters['order'], $parameters['direction'])
            ->get();
    }
}
