<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Etat;
use App\Models\Projet;

class Tache extends Model
{
    protected $table = 'taches';

    public function etat()
    {
        return $this->belongsTo(Etat::class, 'id_etat');
    }

    public function projet()
    {
        return $this->belongsTo(Projet::class, 'id_projet');
    }
}
