<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Projet;
use App\Models\Tache;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

use App\Http\Controllers\Controller;



class DashboardController extends Controller
{
    //
    
   
    
    // DashboardController.php
 

    public function chef()
    {
        $user = auth()->user();

        $today = Carbon::today();

        // 1️⃣ Active Projects
        $activeProjects = Projet::whereHas('etat', fn($q) =>
            $q->where('etat', '!=', 'completed')
        )->count();

        // 2️⃣ Tasks Due Today
        $tasksDueToday = Tache::whereDate('deadline', $today)->count();

        // 3️⃣ Pending Approvals
        $pendingApprovals = Projet::whereHas('etat', fn($q) =>
            $q->where('etat', 'pending')
        )->count();

        // 4️⃣ New Issues Raised (today)
        $newIssues = Tache::whereDate('created_at', $today)->count();

        // 📊 Tasks status (Pie chart)
        $tasksByStatus = Tache::selectRaw('etat.etat, COUNT(*) as total')
            ->join('etat', 'etat.id', '=', 'taches.id_etat')
            ->groupBy('etat.etat')
            ->pluck('total', 'etat.etat');

       

        // Get monthly tasks data
        $tasksPerMonth = Tache::select(
                DB::raw('MONTH(created_at) as month'),
                DB::raw('SUM(CASE WHEN id_etat = 3 THEN 1 ELSE 0 END) as completed'), // id_etat = 3 -> Terminé
                DB::raw('COUNT(*) as total'),
                DB::raw('SUM(CASE WHEN deadline < NOW() AND id_etat != 3 THEN 1 ELSE 0 END) as overdue')
            )
            ->groupBy(DB::raw('MONTH(created_at)'))
            ->orderBy(DB::raw('MONTH(created_at)'))
            ->get();

        // Prepare arrays for Chart.js
        $completedTasks = array_fill(0, 12, 0);
        $newTasks = array_fill(0, 12, 0);
        $overdueTasks = array_fill(0, 12, 0);

        foreach ($tasksPerMonth as $task) {
            $monthIndex = $task->month - 1; // January = 0
            $completedTasks[$monthIndex] = $task->completed;
            $newTasks[$monthIndex] = $task->total;
            $overdueTasks[$monthIndex] = $task->overdue;
        }


        return view('dashboard.chef', compact(
            'user',
            'activeProjects',
            'tasksDueToday',
            'pendingApprovals',
            'newIssues',
            'tasksByStatus',
            'completedTasks',
            'newTasks',
            'overdueTasks'
        ));

    }
/*|--------------------------------------------------------------------------
| Dashboard Admin - Abonnements
|--------------------------------------------------------------------------*/
public function admin()
{
    $user = auth()->user();
    $abonnements = DB::table('abonnements')
        ->orderBy('id', 'desc')
        ->paginate(10);

    // Date de référence (aujourd'hui)
    $dateRef = now()->toDateString();

    // Récupérer les abonnements actifs
    $rows = DB::table('user_abonnement')
        ->join('abonnements', 'user_abonnement.id_abonnement', '=', 'abonnements.id')
        ->whereDate('user_abonnement.date_debut', '<=', $dateRef)
        ->where(function ($q) use ($dateRef) {
            $q->whereNull('user_abonnement.date_fin')
              ->orWhereDate('user_abonnement.date_fin', '>=', $dateRef);
        })
        ->select(
            'abonnements.abonnement',
            DB::raw('COUNT(user_abonnement.id_inscri) AS active_count')
        )
        ->groupBy('abonnements.abonnement')
        ->orderBy('abonnements.abonnement')
        ->get();

    // Préparer les données pour le graphe
    $labels = [];
    $values = [];
    foreach ($rows as $r) {
        $labels[] = $r->abonnement ?? 'Inconnu';
        $values[] = (int) $r->active_count;
    }
    $total = array_sum($values);

    return view('dashboard.admin', [
        'user' => $user,
        'subscriptionLabels' => $labels,
        'subscriptionValues' => $values,
        'subscriptionTotal'  => $total,
        'abonnements'        => $abonnements,
    ]);
}
/*--------------------------------------------------------------------------*/

    public function supervieur()
    {
        return view('dashboard.superviseur');                

    }
    public function contribiteur()
    {
        return view('dashboard.contributeur');                
    }
}