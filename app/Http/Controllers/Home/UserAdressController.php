<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use App\Models\UserAddress;
use Illuminate\Http\Request;

class UserAdressController extends Controller
{
    public function index()
    {
        $userAddresses = UserAddress::where('user_id' , auth()->id())->get();
        return view('home.user_profile.addresses' , compact('userAddresses'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'cellphone' => 'required',
            'province' => 'required',
            'city' => 'required',
            'address' => 'required',
            'postal_code' => 'required'
        ]);

        auth()->user()->userAddresses()->create([
            'title' => $request->title,
            'cellphone' => $request->cellphone,
            'province_id' => $request->province,
            'city_id' => $request->city,
            'address' => $request->address,
            'postal_code' => $request->postal_code
        ]);

        return back();
    }

    public function edit(UserAddress $userAddress)
    {
        return view('home.user_profile.address_edit' , compact('userAddress'));
    }

    public function update(Request $request, UserAddress $userAddress)
    {
        $request->validate([
            'title' => 'required',
            'cellphone' => 'required',
            'province' => 'required',
            'city' => 'required',
            'address' => 'required',
            'postal_code' => 'required'
        ]);

        $userAddress->update([
            'user_id' => auth()->id(),
            'title' => $request->title,
            'cellphone' => $request->cellphone,
            'province_id' => $request->province,
            'city_id' => $request->city,
            'address' => $request->address,
            'postal_code' => $request->postal_code
        ]);

        return redirect()->route('home.profile.addresses.index');
    }

    public function destroy(UserAddress $userAddress)
    {
        $userAddress->delete();
        return back();
    }
}
