<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserResource;

class UserController extends Controller
{

    public function getUser()
    {
        return auth()->check() ? new UserResource(auth()->user()) : null;
    }
}
