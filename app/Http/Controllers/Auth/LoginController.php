<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class LoginController extends Controller
{
    
    // Show login form
    public function showLoginForm()
    {
        return view('auth.login');
    }

    // Handle login
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        // 1. Check if email exists
        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return back()->withErrors([
                'email' => 'This email address is not registered.',
            ])->withInput();
        }

        // 2. Check password
        if (!Hash::check($request->password, $user->password)) {
            return back()->withErrors([
                'password' => 'Incorrect password.',
            ])->withInput();
        }

        // 3. Login success
        Auth::login($user);
        $request->session()->regenerate();

        // 4. Redirect by role
        switch ($user->role->role) {
            case 'Chef de projet':
                return redirect()->route('dashboard.chef');
            case 'Administrateur':
                return redirect()->route('dashboard.admin');
            case 'Superviseur':
                return redirect()->route('dashboard.superviseur');
            case 'Contributeur de projet':
                return redirect()->route('dashboard.contributeur');
            default:
                return redirect()->route('home');
        }



    }

    // Logout
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login');
    }
}
