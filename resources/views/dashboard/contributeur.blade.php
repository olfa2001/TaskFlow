
@extends('layouts.contributeur_layout')

@section('title', 'Contributeur | Dashboard')

@section('content')



<div class="bg-white rounded-2xl shadow p-6">

    <h2 class="text-2xl font-bold mb-4">Liste de mes tâches</h2>

    @if($tasks->count())
        <div class="max-h-[500px] overflow-y-auto space-y-3 pr-2">

            @foreach($tasks as $task)
                <div class="bg-gray-50 p-4 rounded-xl shadow flex justify-between items-center">

                    <div>
                        <h3 class="font-semibold text-lg">{{ $task->nom_tache }}</h3>
                        <p class="text-sm text-gray-500">
                            {{ $task->projet->nom ?? '—' }}
                        </p>
                    </div>

                    <div class="text-right">
                        <span class="text-sm font-medium">
                            {{ $task->priorite }}
                        </span>
                        <p class="text-xs text-gray-400">
                            {{ $task->deadline }}
                        </p>
                    </div>

                </div>
            @endforeach

        </div>
    @else
        <p class="text-gray-500 text-center py-8">
            Aucune tâche assignée pour le moment 👀
        </p>
    @endif

</div>



    {{-- BAS DE PAGE --}}
    <div class="grid grid-cols-1 xl:grid-cols-2 gap-6">

        {{-- PIE CHART --}}
        <div class="bg-white rounded-2xl p-6 shadow">
            <h2 class="font-semibold text-lg mb-4">Répartition de mes tâches</h2>
            <canvas id="tasksChart"></canvas>
        </div>

        {{-- ACTIVITÉ --}}
        <div class="bg-white rounded-2xl p-6 shadow">
            <h2 class="font-semibold text-lg mb-4">Activité récente</h2>
            <ul class="space-y-3 text-sm">
                @forelse ($recentTasks as $task)
                    <li class="flex justify-between">
                        <span>{{ $task->nom_tache }}</span>
                        <span class="text-slate-400">
    {{ $task->updated_at ? \Carbon\Carbon::parse($task->updated_at)->diffForHumans() : '—' }}
</span>

                    </li>
                @empty
                    <li class="text-slate-400">Aucune activité récente</li>
                @endforelse
            </ul>
        </div>

    </div>
</div>

{{-- Chart.js rendering (single instance) --}}
<script>
    (function () {
        const labels = @json(array_keys($tasksByStatus ?? []));
        const values = @json(array_values($tasksByStatus ?? []));


        const ctx = document.getElementById('tasksChart');
        if (!ctx) return;

        new Chart(ctx.getContext('2d'), {
            type: 'pie',
            data: {
                labels: labels.length ? labels : ['Aucune donnée'],
                datasets: [{
                    data: values.length ? values : [1],
                    backgroundColor: ['#22c55e', '#f59e0b', '#3b82f6', '#ef4444', '#a855f7', '#eab308']
                }]
            },
            options: {
                plugins: {
                    legend: { position: 'right' }
                }
            }
        });
    })();
</script>
@endsection
