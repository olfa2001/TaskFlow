@extends('layouts.chef_layout')

@section('title', 'Chef De Projet | Dashboard Home')

@section('content')

<div class="space-y-6">

    {{-- TOP ROW --}}
    <div class="grid grid-cols-1 xl:grid-cols-3 gap-6">

        {{-- Project Overview --}}
        <div class="xl:col-span-2 bg-white rounded-2xl p-6 shadow">
            {{-- Header --}}
            <div class="flex justify-between items-center mb-8">
                <div>
                    <h2 class="font-semibold text-lg text-slate-900">Project Overview</h2>
                    <p class="text-sm text-slate-400 mt-1">Today</p>
                </div>

                <button class="flex items-center gap-2 border border-slate-200 px-4 py-2 rounded-lg text-sm text-slate-600 hover:bg-slate-50">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="1.5"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M12 16v-8m0 0l-3 3m3-3l3 3M4 16.5A2.5 2.5 0 016.5 14h11a2.5 2.5 0 012.5 2.5" />
                    </svg>
                    Export
                </button>
            </div>

            {{-- Cards --}}
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6">

                {{-- Active Projects --}}
                <div class="bg-rose-100 rounded-2xl p-5">
                    <div class="w-10 h-10 rounded-full bg-rose-500 flex items-center justify-center mb-4">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" stroke-width="2"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M3 3v18h18M7 13h3v5H7zm5-4h3v9h-3zm5-6h3v15h-3z" />
                        </svg>
                    </div>

                    <h3 class="text-xl font-bold">{{ $activeProjects }}</h3>
                    <p class="text-sm text-slate-600 mt-1">Active Projects</p>
                    <p class="text-xs text-blue-600 mt-2">+2 since last week</p>
                </div>

                {{-- Tasks Due Today --}}
                <div class="bg-amber-100 rounded-2xl p-5">
                    <div class="w-10 h-10 rounded-full bg-amber-400 flex items-center justify-center mb-4">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" stroke-width="2"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M9 12h6m-6 4h6M9 8h6m3-5H6a2 2 0 00-2 2v14a2 2 0 002 2h12a2 2 0 002-2V5a2 2 0 00-2-2z" />
                        </svg>
                    </div>

                    <h3 class="text-xl font-bold">{{ $tasksDueToday }}</h3>
                    <p class="text-sm text-slate-600 mt-1">Tasks Due Today</p>
                    <p class="text-xs text-blue-600 mt-2">+5 from yesterday</p>
                </div>

                {{-- Pending Approvals --}}
                <div class="bg-emerald-100 rounded-2xl p-5">
                    <div class="w-10 h-10 rounded-full bg-emerald-500 flex items-center justify-center mb-4">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" stroke-width="2"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M5 13l4 4L19 7" />
                        </svg>
                    </div>

                    <h3 class="text-xl font-bold">{{ $pendingApprovals }}</h3>
                    <p class="text-sm text-slate-600 mt-1">Pending Approvals</p>
                    <p class="text-xs text-blue-600 mt-2">6 Approvals Waiting</p>
                </div>

                {{-- New Issues --}}
                <div class="bg-violet-100 rounded-2xl p-5">
                    <div class="w-10 h-10 rounded-full bg-violet-500 flex items-center justify-center mb-4">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" stroke-width="2"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M15 17h5l-1.4-1.4a2 2 0 01-.6-1.4V11a6 6 0 10-12 0v3.2a2 2 0 01-.6 1.4L4 17h5" />
                        </svg>
                    </div>

                    <h3 class="text-xl font-bold">{{ $newIssues }}</h3>
                    <p class="text-sm text-slate-600 mt-1">New Issues Raised</p>
                    <p class="text-xs text-blue-600 mt-2">−1 from yesterday</p>
                </div>

            </div>
        </div>


        {{-- Performance Line Chart --}}
        
        <div class="bg-white rounded-2xl p-6 shadow">
            <h2 class="font-semibold text-lg mb-4">Project Performance Insights</h2>
            <canvas id="performanceChart" height="180"></canvas>
            
        </div>
    </div>

    {{-- BOTTOM ROW --}}
    <div class="grid grid-cols-1 xl:grid-cols-2 gap-6">

        {{-- Tasks Pie --}}
        <div class="bg-white rounded-2xl p-6 shadow">
            <div class="flex justify-between items-center mb-4">
                <h2 class="font-semibold text-lg">Tasks</h2>
                <span class="bg-blue-50 text-blue-600 text-sm px-3 py-1 rounded-full">
                    This Week
                </span>
            </div>
            <canvas id="tasksChart" height="200"></canvas>

                <script>
                const tasksData = @json($tasksByStatus);

                new Chart(document.getElementById('tasksChart'), {
                    type: 'pie',
                    data: {
                        labels: Object.keys(tasksData),
                        datasets: [{
                            data: Object.values(tasksData),
                            backgroundColor: [
                                '#238899',
                                '#60a5fa',
                                '#f59e0b',
                                '#ef4444'
                            ]
                        }]
                    }
                });
                </script>

        </div>


        {{-- Team Activity --}}
        <div class="bg-white rounded-2xl p-6 shadow">
            <div class="flex justify-between items-center mb-4">
                <h2 class="font-semibold text-lg">Team Activity Log</h2>
                <span class="bg-blue-50 text-blue-600 text-sm px-3 py-1 rounded-full">
                    This Week
                </span>
            </div>
            <canvas id="activityChart" height="200"></canvas>
        </div>

    </div>

</div>

{{-- Charts --}}


<script>
    /* Line Chart */
    new Chart(document.getElementById('performanceChart'), {
        type: 'line',
        data: {
            labels: ['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'],
            datasets: [
                {
                    label: 'Completed Tasks',
                    data: @json($completedTasks),
                    borderColor: '#8b5cf6',
                    tension: 0.4
                },
                {
                    label: 'New Tasks',
                    data: @json($newTasks),
                    borderColor: '#ef4444',
                    tension: 0.4
                },
                {
                    label: 'Overdue Tasks',
                    data: @json($overdueTasks),
                    borderColor: '#22c55e',
                    tension: 0.4
                }
            ]
        },
        options: {
            plugins: { legend: { position: 'bottom' } },
            responsive: true
        }
    });


    /* Tasks Pie */
    new Chart(document.getElementById('tasksChart'), {
        type: 'pie',
        data: {
            labels: ['Completed', 'In Review', 'In Progress', 'Blocked'],
            datasets: [{
                data: [32, 25, 25, 18],
                backgroundColor: ['#0f766e', '#6366f1', '#38bdf8', '#dc2626']
            }]
        },
        options: {
            plugins: { legend: { position: 'right' } }
        }
    });

    /* Team Activity Doughnut */
    new Chart(document.getElementById('activityChart'), {
        type: 'doughnut',
        data: {
            labels: ['Design Tasks', 'Development Tasks', 'Documentation', 'QA Tasks', 'Meetings'],
            datasets: [{
                data: [30, 25, 15, 10, 20],
                backgroundColor: ['#ef4444','#3b82f6','#22c55e','#f59e0b','#eab308']
            }]
        },
        options: {
            plugins: { legend: { position: 'right' } }
        }
    });
</script>

@endsection
