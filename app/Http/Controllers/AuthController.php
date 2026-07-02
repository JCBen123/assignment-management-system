<?php

namespace App\Http\Controllers;

use App\Actions\Fortify\CreateNewUser;
use App\Models\Assignments;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public function login(Request $request): RedirectResponse
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();

            Assignments::markPastDueAsOverdue(Auth::id());

            return redirect()->intended('/');
        }

        throw ValidationException::withMessages([
            'password' => __('Invalid email or password.'),
        ]);
    }

    public function register(Request $request): RedirectResponse
    {
        $user = app(CreateNewUser::class)->create($request->all());

        Auth::login($user);
        $request->session()->regenerate();

        return redirect()->intended('/');
    }
}