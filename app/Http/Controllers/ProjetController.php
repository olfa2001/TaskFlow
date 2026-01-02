<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\User;
use Illuminate\Http\Request;

class ProjetController extends Controller
{
   public function index(Request $request)
{
    $filter = $request->get('filter', 'all');

    $query = Project::with(['etat', 'superviseur']);

    if ($filter === 'favorites') {
        $query->where('is_favorite', 1);
    }

    if ($filter === 'archived') {
        $query->where('id_etat', 4);
    }

    $projects = $query->get();

    $users = User::all();


    return view('projects.index', compact('projects', 'filter', 'users'));
}

public function toggleFavorite(Project $project)
{
    $project->update([
        'is_favorite' => !$project->is_favorite
    ]);

    return back();
}
public function addSupervisor(Request $request, Project $project)
{
    $request->validate([
        'superviseur_id' => 'required|exists:users,id',
    ]);

    $user = User::find($request->superviseur_id);

    if($user->role->role !== 'Superviseur'){
        return back()->withErrors(['superviseur_id' => 'L’utilisateur doit être un superviseur.']);
    }

    $superviseurs = $project->other_superviseurs ?? [];

    
    if (!in_array($user->id, $superviseurs) && $user->id != $project->id_user) {
        $superviseurs[] = $user->id;
    }

    $project->other_superviseurs = $superviseurs;
    $project->save();

    return back()->with('success', 'Superviseur ajouté avec succès !');
}



    public function create()
    {
        $superviseurs = User::whereHas('role', fn($q) => $q->where('role','Superviseur'))->get();

        return view('projects.form', compact('superviseurs'));
    }

    public function edit(Project $project)
    {
        $superviseurs = User::whereHas('role', fn($q) => $q->where('role','Superviseur'))->get();

        return view('projects.form', compact('project', 'superviseurs'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nom_projet' => 'required|unique:projets,nom_projet',
            'deadline'   => 'required|date',
            'date_debut' => 'required|date',
            'id_etat'    => 'required|in:1,2,3,4',
            'id_user'    => 'required|exists:users,id',
        ]);

        $superviseur = User::where('id', $validated['id_user'])
                           ->whereHas('role', fn($q) => $q->where('role', 'Superviseur'))
                           ->first();

        if (!$superviseur) {
            return back()->withErrors(['id_user' => 'L’utilisateur assigné doit être un superviseur.'])
                         ->withInput();
        }

        Project::create([
            'nom_projet' => $validated['nom_projet'],
            'description'=> $request->description,
            'date_debut' => $validated['date_debut'],
            'deadline'   => $validated['deadline'],
            'id_user'    => $validated['id_user'],
            'id_etat'    => $validated['id_etat'],
        ]);

        return redirect()->route('projects.index')
                         ->with('success', 'Projet créé avec succès !');
    }

    public function update(Request $request, Project $project)
    {
        $validated = $request->validate([
            'nom_projet' => 'required|unique:projets,nom_projet,' . $project->id,
            'deadline'   => 'required|date',
            'date_debut' => 'required|date',
            'id_etat'    => 'required|in:1,2,3,4',
            'id_user'    => 'required|exists:users,id',
        ]);

        $superviseur = User::where('id', $validated['id_user'])
                           ->whereHas('role', fn($q) => $q->where('role', 'Superviseur'))
                           ->first();

        if (!$superviseur) {
            return back()->withErrors(['id_user' => 'L’utilisateur assigné doit être un superviseur.'])
                         ->withInput();
        }

        $project->update([
            'nom_projet' => $validated['nom_projet'],
            'description'=> $request->description,
            'date_debut' => $validated['date_debut'],
            'deadline'   => $validated['deadline'],
            'id_user'    => $validated['id_user'],
            'id_etat'    => $validated['id_etat'],
        ]);

        return redirect()->route('projects.index')
                         ->with('success', 'Projet mis à jour avec succès !');
    }

    public function destroy(Project $project)
    {
        $project->delete();
        return redirect()->route('projects.index')
                         ->with('success', 'Projet supprimé !');
    }

    public function archive(Project $project)
    {
        $project->update(['id_etat' => 4]);
        return redirect()->route('projects.index')
                         ->with('success', 'Projet archivé !');
    }
}
