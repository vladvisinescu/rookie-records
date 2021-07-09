<?php

namespace App\Http\Controllers;

use App\Models\Address;
use App\Http\Requests\Addresses\CreateAddressRequest;
use App\Http\Requests\Addresses\UpdateAddressRequest;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class AddressController extends Controller
{
    public function getAllAddresses(Request  $request)
    {
        return $request->user()->addresses()->get();
    }

    public function updateAddress(UpdateAddressRequest $request, Address $address)
    {
        $request->user()->addresses()->update(['default' => false]);

        return $address->update($request->all());
    }

    public function saveAddress(CreateAddressRequest $request)
    {
        $request->user()->addresses()->update(['default' => false]);

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

    public function deleteAddress(Address $address)
    {
        $address->delete();

        return response()->json([], 200);
    }

    public function postcodeLookup($postcode)
    {
        return Http::get(config('app.postcode_lookup_base_url') . '/find/' . $postcode, [
            'api-key' => config('app.postcode_lookup_key'),
            'expand' => 'true'
        ])->json();
    }
}
