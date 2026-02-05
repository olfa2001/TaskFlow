<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Projet;
use App\Models\Tache;
use App\Models\Tache as ModelsTache;
use Carbon\Carbon;
use DB;
use App\Models\Task;

class DashboardController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | DASHBOARD CHEF
    |--------------------------------------------------------------------------
    */
    public function chef()
    {
        $user = auth()->user();
        $today = Carbon::today();

        $activeProjects = Projet::whereHas('etat', fn($q) =>
            $q->where('etat', '!=', 'completed')
        )->count();

        $tasksDueToday = Tache::whereDate('deadline', $today)->count();

        $pendingApprovals = Projet::whereHas('etat', fn($q) =>
            $q->where('etat', 'pending')
        )->count();

        $newIssues = Tache::whereDate('created_at', $today)->count();

        $tasksByStatus = Tache::selectRaw('etat.etat, COUNT(*) as total')
            ->join('etat', 'etat.id', '=', 'taches.id_etat')
            ->groupBy('etat.etat')
            ->pluck('total', 'etat.etat');

        $tasksPerMonth = Tache::select(
                DB::raw('MONTH(created_at) as month'),
                DB::raw('SUM(CASE WHEN id_etat = 3 THEN 1 ELSE 0 END) as completed'),
                DB::raw('COUNT(*) as total'),
                DB::raw('SUM(CASE WHEN deadline < NOW() AND id_etat != 3 THEN 1 ELSE 0 END) as overdue')
            )
            ->groupBy(DB::raw('MONTH(created_at)'))
            ->orderBy(DB::raw('MONTH(created_at)'))
            ->get();

        $completedTasks = array_fill(0, 12, 0);
        $newTasks = array_fill(0, 12, 0);
        $overdueTasks = array_fill(0, 12, 0);

        foreach ($tasksPerMonth as $task) {
            $index = $task->month - 1;
            $completedTasks[$index] = $task->completed;
            $newTasks[$index] = $task->total;
            $overdueTasks[$index] = $task->overdue;
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
public function messages()
{
    // Ici tu peux récupérer des messages depuis ta DB si tu en as
    // Exemple minimal :
    $messages = []; // Remplace par ta requête réelle si nécessaire

    return view('contributeur.message', compact('messages'));
}


    /*
    |--------------------------------------------------------------------------
    | DASHBOARD SUPERVISEUR
    |--------------------------------------------------------------------------
    */
    public function superviseur()
{
    $user = auth()->user();

    // Projects assigned to this supervisor
    $projects = $user->projetsSupervised()
        ->with('taches', 'contributeurs')
        ->get();

    /*
    |--------------------------------------------------------------------------
    | TASK PROGRESS BY MONTH (used for stats)
    |--------------------------------------------------------------------------
    */
    $taskProgressByMonth = [];

    for ($month = 1; $month <= 12; $month++) {
        $monthData = [];

        foreach ($projects as $project) {
            $tasksInMonth = $project->taches->filter(fn ($tache) =>
                \Carbon\Carbon::parse($tache->created_at)->month === $month
            );

            $totalTasks = $tasksInMonth->count();
            $completedTasks = $tasksInMonth->where('id_etat', 3)->count();

            $monthData[] = [
                'project_name'     => $project->nom_projet,
                'total_tasks'      => $totalTasks,
                'completed_tasks'  => $completedTasks,
                'progress'         => $totalTasks > 0
                    ? round(($completedTasks / $totalTasks) * 100)
                    : 0,
            ];
        }

        $taskProgressByMonth[$month] = $monthData;
    }

    /*
    |--------------------------------------------------------------------------
    | BAR CHART DATA (COMPLETED / IN PROGRESS / PENDING)
    |--------------------------------------------------------------------------
    */
    $tasksCompletedByMonth  = array_fill(0, 12, 0);
    $tasksInProgressByMonth = array_fill(0, 12, 0);
    $tasksPendingByMonth    = array_fill(0, 12, 0);

    for ($month = 1; $month <= 12; $month++) {
        $index = $month - 1;

        $tasksCompletedByMonth[$index] = Tache::whereIn('id_projet', $projects->pluck('id'))
            ->where('id_etat', 3) // completed
            ->whereMonth('created_at', $month)
            ->count();

        $tasksInProgressByMonth[$index] = Tache::whereIn('id_projet', $projects->pluck('id'))
            ->where('id_etat', 2) // in progress
            ->whereMonth('created_at', $month)
            ->count();

        $tasksPendingByMonth[$index] = Tache::whereIn('id_projet', $projects->pluck('id'))
            ->where('id_etat', 1) // pending
            ->whereMonth('created_at', $month)
            ->count();
    }

    /*
    |--------------------------------------------------------------------------
    | LINE CHART – PROJECT PROGRESS
    |--------------------------------------------------------------------------
    */
    $monthlyProjectProgress = [];

    foreach ($projects as $project) {
        $monthlyData = Tache::select(
                DB::raw('MONTH(created_at) as month'),
                DB::raw('COUNT(*) as completed')
            )
            ->where('id_projet', $project->id)
            ->where('id_etat', 3)
            ->groupBy(DB::raw('MONTH(created_at)'))
            ->pluck('completed', 'month')
            ->toArray();

        $monthlyArray = array_fill(0, 12, 0);

        foreach ($monthlyData as $m => $count) {
            $monthlyArray[$m - 1] = $count;
        }

        $monthlyProjectProgress[] = [
            'project_name'      => $project->nom_projet,
            'monthly_completed' => $monthlyArray,
        ];
    }

    return view('dashboard.superviseur', compact(
        'user',
        'taskProgressByMonth',
        'monthlyProjectProgress',
        'tasksCompletedByMonth',
        'tasksInProgressByMonth',
        'tasksPendingByMonth'
    ));
}

    /*
    |--------------------------------------------------------------------------
    | AUTRES DASHBOARDS
    |--------------------------------------------------------------------------
    */
    public function admin()
    {
        $user = auth()->user();

        $abonnements = DB::table('abonnements')
            ->orderBy('id', 'desc')
            ->paginate(10);

        $dateRef = now()->toDateString();

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
public function reports()
{
    return view('contributeur.reports');
}
public function settings()
{
    return view('contributeur.settings');
}

        /**
     * Dashboard Contributeur
     */

       public function contributeur()
{
    $user = Auth::user();
    $today = Carbon::today();

    // 🔹 Tâches assignées directement au contributeur
    $tasks = Tache::with(['etat', 'projet'])
        ->where('id_contributeur', $user->id)
        ->orderBy('deadline')
        ->get();

    // 🔢 Statistiques
    $totalTasks = $tasks->count();

    $inProgressTasks = $tasks->filter(fn ($t) =>
        $t->etat && $t->etat->etat === 'en cours'
    )->count();

    $completedTasksCount = $tasks->filter(fn ($t) =>
        $t->etat && $t->etat->etat === 'terminé'
    )->count();

    $overdueTasks = $tasks->filter(fn ($t) =>
        $t->deadline < $today &&
        $t->etat &&
        $t->etat->etat !== 'terminé'
    );

    // 📊 IMPORTANT : données pour Chart.js
    $tasksByStatus = $tasks
        ->groupBy(fn ($t) => $t->etat->etat ?? 'Inconnu')
        ->map(fn ($group) => $group->count())
        ->toArray();

    // 🕒 Activité récente
    $recentTasks = $tasks->sortByDesc('updated_at')->take(5);

    return view('dashboard.contributeur', compact(
        'tasks',
        'totalTasks',
        'inProgressTasks',
        'completedTasksCount',
        'overdueTasks',
        'tasksByStatus',
        'recentTasks'
    ));
}
public function index()
{
    $user = Auth::user();

    // tâches assignées au contributeur
    $tasks = Tache::with('projet')
        ->where('id_contributeur', $user->id)
        ->orderBy('deadline', 'asc')
        ->get();

    return view('dashboard.contributeur', compact('tasks'));
}
}
