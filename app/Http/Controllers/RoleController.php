<?php

namespace App\Http\Controllers;
use App\Models\Role;
class AbonnementController extends Controller
{
    
    public function gest_roles()
    {
        $roles = Role::all();
        return view('roles.gest_roles', compact('roles'));
    }



}
