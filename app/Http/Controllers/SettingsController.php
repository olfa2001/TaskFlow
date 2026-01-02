<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class SettingsController extends Controller
{
    public function index()
    {
        return view('chef.settings', [
            'user' => Auth::user(),
        ]);
    }

    public function update(Request $request)
{
    $user = Auth::user();

    $data = $request->validate([
        'nom'             => 'nullable|string|max:255',
        'prenom'          => 'nullable|string|max:255',
        'email'           => 'required|email|unique:users,email,' . $user->id,
        'country_code'    => 'required|string|max:5',
        'phone'           => 'nullable|string|max:20',
        'password'        => 'nullable|min:6|confirmed',
        'photo'           => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:4096',
        'date_naissance'  => 'nullable|date',
    ]);

    // ✅ Combine country code + phone
    if (!empty($data['phone'])) {
        $data['phone'] = $data['country_code'] . $data['phone'];
    }
    unset($data['country_code']);

    // Handle avatar upload
    if ($request->hasFile('photo')) {
        $file = $request->file('photo');
        $filename = time() . '_' . $file->getClientOriginalName();
        $file->move(public_path('images'), $filename);
        $data['photo'] = 'images/' . $filename;
    }

    // Password handling
    if (!empty($data['password'])) {
        $data['password'] = Hash::make($data['password']);
    } else {
        unset($data['password']);
    }

    $user->update($data);

    return back()->with('success', 'Profil mis à jour avec succès.');
}
}