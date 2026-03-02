<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SessionsController extends Controller
{
    public function create() {
        return view('auth.login');
    }

    public function store() {
        $attributes = request()->validate([
            'email' => ['required', 'string', 'max:255', 'email'],
            'password' => ['required', 'string', 'max:255'],
        ]);

        if (! auth()->attempt($attributes)) {
            return back()
                ->withErrors(['password' => 'Your provided credentials could not be verified.'])
                ->withInput();
        }

        session()->regenerate();

        return redirect()->route('home')->with('success', 'You have been logged in.');
    }

    public function destroy() {
        auth()->logout();

        return redirect()->route('home')->with('success', 'You have been logged out.');
    }
}
