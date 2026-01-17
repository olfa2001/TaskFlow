<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Abonnement;
use App\Models\Role;
use Illuminate\Support\Facades\DB;

class OptionalController extends Controller
{
    // SHOW OPTIONAL FORM
    public function show($user_id)
    {
        $user = User::findOrFail($user_id);
        $abonnements = Abonnement::all();
        $roles = Role::all(); // ✅ must be passed to view

        return view('auth.optional', compact('user', 'abonnements', 'roles'));
    }

    // STORE OPTIONAL INFO
    public function store(Request $request, $user_id)
    {
        $request->validate([
            'phone' => 'nullable|string|max:20',
            'profession' => 'nullable|string|max:150',
            'bio' => 'nullable|string|max:255',
            'photo' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'id_abonnement' => 'required|exists:abonnements,id',
            'id_role' => 'required|exists:roles,id',
        ]);

        $user = User::findOrFail($user_id);

        if ($request->hasFile('photo')) {
            $path = $request->file('photo')->store('photos', 'public');
            $user->photo = $path;
        }

        $user->phone = $request->phone;
        $user->profession = $request->profession;
        $user->bio = $request->bio;
        $user->id_abonnement = $request->id_abonnement;
        $user->id_role = $request->id_role;
        $user->save();

        DB::table('user_abonnement')->insert([
            'id_inscri' => $user->id,
            'id_abonnement' => $request->id_abonnement,
            'date_debut' => now()->toDateString(),
            'date_fin' => now()->addMonth()->toDateString(),
        ]);

          return redirect()->route('login')
                         ->with('success', 'Inscription terminée. Connectez-vous.');
    }
}
