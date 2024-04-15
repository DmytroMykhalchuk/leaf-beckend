<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\BaseController;

class UserController extends BaseController
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }
}
