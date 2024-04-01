<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\AbstractController;

class UserController extends AbstractController
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }
}
