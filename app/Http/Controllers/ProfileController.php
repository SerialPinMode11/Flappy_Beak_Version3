<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    public function edit()
    {
        return view('customer.profile', [
            'user' => auth()->user(),
        ]);
    }

    public function update(Request $request)
    {
        $user = auth()->user();

        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'nullable|string|max:50',
            'address' => 'required|string|max:500',
            'city' => 'required|string|max:255',
            'zip' => 'required|string|max:32',
            'avatar' => 'nullable|image|max:2048',
            'remove_avatar' => 'nullable|boolean',
        ]);

        $user->name = $request->name;
        $user->phone = $request->phone;
        $user->address = $request->address;
        $user->city = $request->city;
        $user->zip = $request->zip;

        if ($request->boolean('remove_avatar') && $user->avatar_path) {
            Storage::disk('public')->delete($user->avatar_path);
            $user->avatar_path = null;
        }

        $avatarFile = $request->file('avatar');
        if ($avatarFile) {
            if ($user->avatar_path) {
                Storage::disk('public')->delete($user->avatar_path);
            }
            $user->avatar_path = $avatarFile->store('avatars', 'public');
        }

        $user->save();

        return redirect()->route('profile.edit')->with('success', 'Your profile has been saved.');
    }
}
