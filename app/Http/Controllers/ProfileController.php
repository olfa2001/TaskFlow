<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Projet;

class ProfileController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // Fetch projects assigned to this user
        $projects = Projet::where('id_user', $user->id)->get();

        return view('chef.profile', compact('user', 'projects'));
    }

    public function updateBio(Request $request)
    {
        $request->validate([
            'bio' => 'nullable|string|max:255',
        ]);

        $user = auth()->user();
        $user->bio = $request->bio;
        $user->save();

        // Return JSON
        return response()->json([
            'success' => true,
            'bio' => $user->bio,
        ]);
    }
}
