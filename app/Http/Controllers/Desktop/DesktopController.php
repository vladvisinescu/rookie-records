<?php

namespace App\Http\Controllers\Desktop;

use App\Http\Controllers\Controller;

class DesktopController extends Controller
{

    public function home()
    {
        return view('desktop.home');
    }
}
