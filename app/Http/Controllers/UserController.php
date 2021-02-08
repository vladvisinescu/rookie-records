<?php

namespace App\Http\Controllers;

class UserController extends Controller
{

    public function getUser()
    {
        return auth()->user;
    }

    public function updateContactDetails()
    {
        return auth()->user()->contactDetails();
    }
}
