<?php

namespace App\Http\Controllers\Back;

use App\Base\BaseController;
use App\Models\Devices;
use App\Traits\Indexable;
use App\Repositories\DevicesRepository;

class DeviceController extends BaseController
{
    use Indexable;

    public function __construct(DevicesRepository $repository)
    {
        $this->repository = $repository;

        $this->table = 'devices';
    }

    public function kick(){

    }
}