<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserRegisterController extends Controller
{
    public function create()
    {
        return view('auth.register');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'          => 'required|string|max:255',
            'email'         => 'required|email|unique:users,email',
            'password'      => 'required|string',
            'profile_image' => 'required|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $user = User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
            'is_admin' => false,
        ]);

        $path = null;
        if ($request->hasFile('profile_image')) {
            $file = $request->file('profile_image');
            $extension = $file->getClientOriginalExtension(); // jpg, png, etc.
            $fileName = $user->id . '.' . $extension;
            $file->storeAs('profiles', $fileName, 'public');
            $path = 'profiles/' . $fileName;
            $user->update(['profile_image' => $path]);
        }

        return redirect()->route('attendance.dashboard')
            ->with('success', 'User registered successfully!');
    }
}
