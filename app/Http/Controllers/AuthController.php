<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function showRegister()
    {
        return view('auth.register');
    }

    public function showLogin()
    {
        return view('auth.login');
    }

    public function register(Request $request)
    {
        // 1) Validate
        $validated = $request->validate([
            'name' => ['required','string','max:255'],
            'email' => ['required','string','email','max:255','unique:users,email','ends_with:cmb.ac.lk'],
            'password' => ['required','string','min:8','confirmed'], // needs password_confirmation
        ],[
            'email.ends_with' => 'Please use a university email that ends with cmb.ac.lk',
        ]);

        // 2) Create user with hashed password
        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => $validated['password'],
        ]);

        // 3) Log in user
        Auth::login($user);

        // 4) Prevent session fixation
        $request->session()->regenerate();

        return redirect()->route('dashboard');
    }

    public function login(Request $request)
    {
        // Validate
        $credentials = $request->validate([
            'email' => ['required','email'],
            'password' => ['required','string'],
        ]);

        // Attempt login (Laravel checks hashed password automatically)
        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate(); // prevent session fixation
            return redirect()->intended(route('dashboard'));
        }

        return back()->withErrors([
            'email' => 'Invalid email or password.',
        ])->onlyInput('email');
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login.show');
    }
}