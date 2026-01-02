<?php

namespace App\Models;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
class User extends Authenticatable
{
    use Notifiable;

    protected $table = 'users';

    protected $primaryKey = 'id';

    public $timestamps = false; // IMPORTANT (your table has no created_at)

    protected $hidden = ['pw'];



    public function getAuthPassword()
    {
        return $this->pw;
    }

  
    public function getNameAttribute()
    {
        return $this->prenom . ' ' . $this->nom;
    }


    public function role()
    {
        return $this->belongsTo(Role::class, 'id_role');
    }
     public function projets() {
        return $this->hasMany(Project::class, 'id_user');
    }

}
