<?php

namespace App\Http\Controllers;
use App\Models\Abonnement;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
class AbonnementController extends Controller
{
    public function index()
    {

        return view('dashboard.admin', compact('abonnements'/*, 'subscriptionLabels', 'subscriptionValues', 'subscriptionTotal'*/));
    }
    
    public function index_abonnement()
    {
        return view('abonnements.abonnement');
    }
     public function gest_abonnement()
    {
        $abonnements = Abonnement::all();
        return view('abonnements.gest_abonnements', compact('abonnements'));
    }
    public function gest_roles()
    {
        $roles = Role::all();
        return view('roles.gest_roles', compact('roles'));
    }


    public function create()
    {
        return view('abonnements.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'abonnement' => 'required|string|max:150',
            'description' => 'nullable|string|max:500',
            'prix'        => 'required|numeric|min:0',
        ]);

        Abonnement::create($validated);
        return redirect()->route('admin.abonnements.gest_abonnements')->with('success', 'Offre créée.');
    }

    
// Edit: afficher le formulaire

// Edit: affiche le formulaire (déjà correct)
public function edit(Abonnement $abonnement) {
    return view('abonnements.edit', compact('abonnement'));
}

// Update: traiter la mise à jour (corrigé)
public function update(Request $request, Abonnement $abonnement) {
    $validated = $request->validate([
        'abonnement'  => ['required', 'string', 'max:150'],
        'description' => ['nullable', 'string', 'max:500'],
        'prix'        => ['required', 'numeric', 'min:0'],
    ]);

    $abonnement->update($validated);

    return redirect()->route('admin.abonnements.gest_abonnements')
                     ->with('status', 'Offre mise à jour avec succès.');
}

    public function destroy
(Request $request, Abonnement $abonnement)
{
    $id = $abonnement->id;
    $abonnement->delete();

    // Si l’appel AJAX envoie Accept: application/json, on renvoie un JSON ou 204
    if ($request->expectsJson()) {
        return response()->json([
            'message' => 'Offre supprimée.',
            'id' => $id,
        ], 200);
        // ou : return response()->noContent(); // 204 No Content
    }

    // fallback (cas non-AJAX)
    return redirect()->route('admin.abonnements.gest_abonnements')->with('success', 'Offre supprimée.');



    }
}
