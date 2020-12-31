<?php

namespace App\Http\Controllers\Desktop;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\DiscogsSearchRequest;
use App\Services\DiscogsService;

class DiscogsController extends Controller
{

    public function search(DiscogsSearchRequest $request)
    {$request->input('term'));
        $result = (new DiscogsService)->search($request->input('term'), [
            'release'
        ]);

        dd($result->getSearch('release'));
    }
}
