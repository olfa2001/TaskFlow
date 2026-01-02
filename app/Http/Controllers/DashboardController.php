<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

use App\Http\Controllers\Controller;



class DashboardController extends Controller
{
    //
    
    public function __construct()
    {
        // Protège toutes les routes de ce contrôleur : nécessite un utilisateur connecté
        $this->middleware('auth');
    }

    
    // DashboardController.php
    public function chef()
    {
        $user = auth()->user();

        return view('dashboard.chef', compact('user'));
    }

    public function admin()
    {
        return view('dashboard.admin');
    }
    public function supervieur()
    {
        return view('dashboard.superviseur');                

    }
    public function contribiteur()
    {
        return view('dashboard.contributeur');                
    }
}