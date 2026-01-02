<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
     protected $casts = [
        'other_superviseurs' => 'array',
    ];

    protected $table = 'projets';

    protected $fillable = [
        'nom_projet',
        'description',
        'date_debut',
        'deadline',
        'id_user',
        'is_favorite',
        'id_etat',
    ];

       public function superviseur()
    {
        return $this->belongsTo(User::class, 'id_user');
    }


    public function etat()
    {
        return $this->belongsTo(Etat::class, 'id_etat');
    }
    public function otherSuperviseurs()
    {
        return User::whereIn('id', $this->other_superviseurs ?? [])->get();
    }
}
