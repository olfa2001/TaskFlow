<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Abonnement extends Model
{
    
protected $table = 'abonnements'; // correspond à ta table existante

    // champs modifiables (si tu fais du CRUD)
    protected $fillable = [
        'abonnement',   // nom du plan (Basic, Pro, Business…)
        'description',  // texte libre
        'date_debut',   // date
        'date_fin',     // date
        'prix',         // float
    ];

    protected $casts = [
        'date_debut' => 'date',
        'date_fin'   => 'date',
        'prix'       => 'float',
    ];

    /**
     * Retourne la catégorie UI pour les onglets (individual | business).
     * Comme ta table ne contient pas une colonne 'categorie', on déduit
     * la catégorie depuis le nom du plan (affinable selon ton besoin).
     */
    public function getCategorieAttribute(): string
    {
        $name = strtolower($this->abonnement);
        return match (true) {
            str_contains($name, 'business') => 'business',
            default                         => 'individual',
        };
    }

}
