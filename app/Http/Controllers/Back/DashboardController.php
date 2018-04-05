<?php

namespace App\Http\Controllers\Back;

use App\Base\BaseController;
use App\Http\Controllers\Controller;
use App\Repositories\ConfigAppRepository;
use App\Repositories\EnvRepository;
use App\Services\PannelAdmin;
use Illuminate\Support\Facades\Artisan;

class DashboardController extends BaseController
{
    /**
     * Show the admin dashboard.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {

        if (auth()->user()->hasRole('external')){
            return redirect()->to('/');
        }
        $pannels = [];

        foreach (config('pannels') as $pannel) {

            $panelAdmin = new PannelAdmin($pannel);

            if ($panelAdmin->nbr) {
                $pannels[] = $panelAdmin;
            }
        }

        return view('back.index', compact('pannels'));
    }

    /**
     * Check and refresh cache if exists
     *
     * @return bool
     */
    protected function checkCache()
    {
        if (file_exists(app()->getCachedConfigPath())) {
            Artisan::call('config:clear');
            Artisan::call('config:cache');
            return true;
        }
        return false;
    }
}
