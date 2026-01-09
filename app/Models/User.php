<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Models\Role;
use App\Models\Projet; 
class User extends Authenticatable
{
    use Notifiable;

    protected $table = 'users';
    protected $primaryKey = 'id';
    public $timestamps = false;
    protected $hidden = ['password'];

    protected $fillable = [
        'nom',
        'prenom',
        'email',
        'phone',
        'password',
        'date_naissance',
        'profession',
        'photo'
    ];

    public function getAuthPassword()
    {
        return $this->password;
    }

    public function getNameAttribute()
    {
        return $this->prenom . ' ' . $this->nom;
    }

    public function role()
    {
        return $this->belongsTo(Role::class, 'id_role');
    }

    public function projets()
    {
        return $this->hasMany(Projet::class, 'id_user');
    }
}
