<?php

namespace App\Http\Controllers;
use App\Models\Abonnement; 

use Illuminate\Http\Request;

class AbonnementController extends Controller
{
// Liste + filtre par onglet (individual|business)

    // ⬅️ renommé selon ta demande
    public function index_abonnement(Request $request)
    {
        $categorie = $request->query('categorie', 'individual');

        $plans = Abonnement::query()
            ->when($categorie === 'business', function ($q) {
                $q->whereRaw("LOWER(abonnement) LIKE '%business%'");
            }, function ($q) {
                $q->whereRaw("LOWER(abonnement) NOT LIKE '%business%'");
            })
            ->orderByRaw('CASE LOWER(abonnement)
                WHEN "basic" THEN 1
                WHEN "pro" THEN 2
                WHEN "business" THEN 3
                ELSE 4 END')
            ->get();

        // ⬅️ nouvelle vue: abonnements/abonnement.blade.php
        return view('abonnements.abonnement', compact('plans', 'categorie'));
    }

    // Action "Choisir" (inchangée)
    public function choose(Request $request)
    {
        $request->validate([
            'abonnement_id' => ['required', 'exists:abonnements,id'],
        ]);

        $plan = Abonnement::findOrFail($request->abonnement_id);

        // Ici tu peux enregistrer le choix de l’utilisateur si tu veux
        return redirect()
            ->route('abonnements.index', ['categorie' => $plan->categorie])
            ->with('success', "Abonnement « {$plan->abonnement} » sélectionné.");
    }
}

