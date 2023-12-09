<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserProfileController extends Controller
{
    public function index()
    {
        return view('home.user_profile.index');
    }

    public function updateProfile(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required',
            'password_old' => 'nullable',
            'password_new' => 'nullable|confirmed',
        ]);

        if ($request->password_old !== null && $request->password_new !== null && Hash::check($request->password_old , $user->password)) {
            $user->update([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password_new)
            ]);

            return back();
        }

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
        ]);

        return back();
    }
}
