<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Etat;
use App\Models\Tache;
use App\Models\User;

class Projet extends Model
{
    protected $table = 'projets';

    // Champs autorisés à remplir
    protected $fillable = [
        'nom_projet',
        'description',
        'date_debut',
        'deadline',
        'id_user',
        'is_favorite',
        'id_etat',
        'other_superviseurs',
    ];

    // Pour stocker les autres superviseurs en array
    protected $casts = [
        'other_superviseurs' => 'array',
    ];

    // Relations
    public function superviseur()
    {
        return $this->belongsTo(User::class, 'id_user');
    }

    public function otherSuperviseurs()
    {
        return User::whereIn('id', $this->other_superviseurs ?? [])->get();
    }

    public function etat()
    {
        return $this->belongsTo(Etat::class, 'id_etat');
    }

    public function taches()
    {
        return $this->hasMany(Tache::class, 'id_projet');
    }
}
