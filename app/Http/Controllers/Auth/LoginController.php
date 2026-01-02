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

        $user = User::where('email', $request->email)->first();

        if ($user && Hash::check($request->password, $user->pw)) {
            Auth::login($user);
            $request->session()->regenerate();

            // Redirect based on role
            switch ($user->role->role) { // assuming User model has relation 'role'
                case 'Chef de projet':
                    return redirect()->route('dashboard.chef'); // dashboard route
                case 'Administrateur':
                    return redirect()->route('dashboard.admin');
                case 'Superviseur':
                    return redirect()->route('dashboard.superviseur');
                case 'Contributeur de projet':
                    return redirect()->route('dashboard.contributeur');
                default:
                    return redirect()->route('home'); // fallback
            }
        }

        return back()->withErrors([
            'email' => 'Invalid credentials',
        ]);
        add(Auth::id(), Auth::user()->role->role);

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
