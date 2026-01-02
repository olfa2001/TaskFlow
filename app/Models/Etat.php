<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Etat extends Model
{
    protected $table = 'etat';
    public $timestamps = false;

    protected $fillable = ['etat'];

    public function projects()
    {
        return $this->hasMany(Project::class,'id_etat');
    }
}
