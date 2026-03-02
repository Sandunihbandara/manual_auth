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
            'role' => ['required','in:user,staff'],
            'department' => ['required','in:ICT,IAT,ET,AT'],
            'phone' => ['required','string','max:20','regex:/^[0-9+\-\s]{7,20}$/'],
            'password' => ['required','string','min:8','confirmed'], // needs password_confirmation
        ],[
            'email.ends_with' => 'Please use a university email that ends with cmb.ac.lk',
            'role.in' => 'Role must be user or staff.',
            'department.in' => 'Choose a valid department.',
            'phone.regex' => 'Enter a valid contact number.',
        ]);

        // 2) Create user with hashed password
        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'role' => $validated['role'],
            'department' => $validated['department'],
            'phone' => $validated['phone'],
            'password' => $validated['password'], // hash password before saving    
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