<?php
/**
 * Created by PhpStorm.
 * User: abed.bilani
 * Date: 4/5/2018
 * Time: 10:04 AM
 */

namespace App\Http\Controllers\Api;


use App\Base\BaseCrud;
use App\Models\User;

class UserController extends BaseCrud
{

    public function init()
    {
        $this->model = new User();
    }

//    public function index()
//    {
//        return $this->successData(User::all());
//    }
}