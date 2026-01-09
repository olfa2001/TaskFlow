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
        'prix',         // float
    ];

    protected $casts = [
        'prix'       => 'float',
    ];
    
// Désactive les colonnes created_at / updated_at
    public $timestamps = false;


}
