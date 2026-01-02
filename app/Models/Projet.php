<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Etat;
use App\Models\Tache;

class Projet extends Model
{
    protected $table = 'projets';

    public function etat()
    {
        return $this->belongsTo(Etat::class, 'id_etat');
    }

    public function taches()
    {
        return $this->hasMany(Tache::class, 'id_projet');
    }
}
