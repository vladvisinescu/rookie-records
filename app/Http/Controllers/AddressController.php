<?php

namespace App\Http\Controllers;

use App\Models\Address;
use Illuminate\Http\Request;

use App\Http\Requests\Addresses\CreateAddressRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class AddressController extends Controller
{
    public function getAllAddresses(Request  $request)
    {
        return $request->user()->addresses()->get();
    }

    public function saveAddress(CreateAddressRequest $request)
    {
        return $request->user()->addresses()->create([
            'type' => 'delivery',
            'default' => true,
            'uuid' => Str::uuid(),
            'address_1' => $request->input('address_1'),
            'address_2' => $request->input('address_2'),
            'town' => $request->input('town'),
            'county' => $request->input('county'),
            'country' => $request->input('country'),
            'postcode' => $request->input('postcode'),
        ]);
    }

    public function deleteAddress()
    {

    }
}
