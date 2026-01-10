<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Abonnement;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class OptionalController extends Controller
{
    // Show optional form
    public function show($user_id)
    {
        $user = User::findOrFail($user_id);
        $abonnements = Abonnement::all();

        return view('auth.optional', compact('user', 'abonnements'));
    }

    // Store optional info
    public function store(Request $request, $user_id)
    {
        $request->validate([
            'phone' => 'nullable|string|max:20',
            'profession' => 'nullable|string|max:150',
            'bio' => 'nullable|string|max:255',
            'photo' => 'nullable|image|max:2048',
            'id_abonnement' => 'required|exists:abonnements,id',
        ]);

        $user = User::findOrFail($user_id);

        // Handle photo upload
        $photoPath = $user->photo;
        if ($request->hasFile('photo')) {
            $photoPath = $request->file('photo')->store('photos', 'public');
        }

        // Update user info
        $user->update([
            'phone' => $request->phone,
            'profession' => $request->profession,
            'bio' => $request->bio,
            'photo' => $photoPath,
        ]);

        // Insert subscription (example: 1 month)
        $dateDebut = date('Y-m-d');
        $dateFin = date('Y-m-d', strtotime('+1 month', strtotime($dateDebut)));

        DB::table('user_abonnement')->insert([
            'id_inscri' => $user->id,
            'id_abonnement' => $request->id_abonnement,
            'date_debut' => $dateDebut,
            'date_fin' => $dateFin,
        ]);

        return redirect()->route('home')->with('success', 'Optional info saved!');
    }
}
