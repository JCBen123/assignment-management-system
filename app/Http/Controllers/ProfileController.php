<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function mount()
    {
        return view('pages.settings.profile', [
            'user' => Auth::user(),
        ]);
    }

    public function update(Request $request)
    {
        $validated = $request->validate(['name' => ['required', 'string', 'max:255']]);

        Auth::user()->update($validated);

        return back()->with('status', 'Profile updated successfully');
    }
}
