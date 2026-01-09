<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Projet;

class Etat extends Model
{
    protected $table = 'etat';
    public $timestamps = false;

    protected $fillable = ['etat'];

    public function projets()
    {
        return $this->hasMany(Projet::class, 'id_etat');
    }
}
