<?php

namespace App\Http\Controllers\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    // Show first registration page
    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    // Store user from first page
    public function store(Request $request)
    {
        $request->validate([
            'prenom' => 'required|string|max:100',
            'nom' => 'nullable|string|max:100',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|confirmed|min:6',
            'id_role' => 'required|integer',
        ]);

        // Create user with minimal info
        $user = User::create([
            'prenom' => $request->prenom,
            'nom' => $request->nom,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'id_role' => $request->id_role,
        ]);

        // Redirect to optional info page
        return redirect()->route('register.optional', ['user_id' => $user->id]);
    }
}
