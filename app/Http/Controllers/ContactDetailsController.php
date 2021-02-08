<?php

namespace App\Http\Controllers;

use App\Models\Address;
use Illuminate\Http\Request;

use App\Http\Requests\Addresses\CreateAddressRequest;
use Illuminate\Support\Facades\Auth;

class ContactDetailsController extends Controller
{
    public function getAllAddresses(Request  $request)
    {
        return $request->user()->addresses()->get();
    }

    public function saveAddress(CreateAddressRequest $request)
    {
        $contact = $request->user()->contacts()->create([
            'first_name' => $request->input('first_name'),
            'last_name' => $request->input('last_name'),
            'email' => $request->input('email'),
            'phone' => $request->input('phone'),
        ]);

        return $contact;
    }
}
