<?php

namespace App\Http\Controllers\Desktop;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\DiscogsSearchRequest;
use App\Services\DiscogsService;

class DiscogsController extends Controller
{

    public function search(DiscogsSearchRequest $request)
    {
        $result = (new DiscogsService)->search($request->input('term'));

        dd($result);
    }
}
