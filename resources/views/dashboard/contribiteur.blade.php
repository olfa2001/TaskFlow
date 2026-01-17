{{-- resources/views/dashboard/contributeur.blade.php --}}
@extends('layouts.contributeur_layout') {{-- Adaptez si votre layout est différent --}}

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <h1 class="text-2xl sm:text-3xl font-bold mb-6">Tableau de bord Contributeur</h1>

    <div class="grid grid-cols-1 gap-6">
        <div class="flex flex-wrap gap-6">

            {{-- Box 1: Repartition des taches par défaut --}}
            <div class="rounded-xl border border-gray-200 bg-white p-5 shadow-sm w-full md:w-[48%]">
                <div class="flex items-center justify-between">
                    <div>
                        <h2 class="text-lg font-semibold text-gray-800">Statistiques des taches</h2>
                        <p class="mt-1 text-sm text-gray-500">
                            Répartition des taches <strong>actifs</strong> par plan (aujourd’hui).
                        </p>
                    </div>
                    <div class="flex h-12 w-12 items-center justify-center rounded-lg bg-cyan-50 text-cyan-600">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 3v18h18M7 15l3-3 4 4 5-6" />
                        </svg>
                    </div>
                </div>

                {{-- Total taches --}}
                <div class="mt-4 flex items-center gap-4">
                    <div class="text-sm text-gray-600">Total taches actives :</div>
                    <div class="text-lg font-semibold text-gray-900">{{ $subscriptionTotal ?? 0 }}</div>
                </div>

                {{-- Graphe + légende --}}
                <div class="mt-4 flex flex-col sm:flex-row gap-6">
                    <div class="flex-1">
                        <div class="relative h-56 sm:h-64 lg:h-72">
                            <canvas id="abonnementsActifsDonut" class="w-full h-full"></canvas>
                        </div>
                    </div>

                    {{-- Légende --}}
                    <div class="space-y-2 w-full sm:w-[180px]">
                        @php
                            $labels = $subscriptionLabels ?? [];
                            $values = $subscriptionValues ?? [];
                            $total  = $subscriptionTotal ?? 0;
                            $palette = ['#06b6d4','#8b5cf6','#f59e0b','#10b981','#ef4444','#3b82f6','#a3e635','#f97316'];
                        @endphp

                        @forelse ($labels as $i => $label)
                            @php
                                $val   = $values[$i] ?? 0;
                                $pct   = $total > 0 ? round(($val / $total) * 100, 1) : 0;
                                $color = $palette[$i % count($palette)];
                            @endphp
                            <div class="flex items-center justify-between rounded-lg border border-gray-100 p-2">
                                <div class="flex items-center gap-2">
                                    <span class="inline-block w-4 h-3 rounded-sm" ></span>
                                    <span class="text-sm text-gray-700">{{ $label }}</span>
                                </div>
                                <span class="text-sm font-semibold text-gray-900">{{ $val }} ({{ $pct }}%)</span>
                            </div>
                        @empty
                            <div class="rounded-lg border border-gray-100 p-3 text-sm text-gray-500">
                                Aucune inscription active pour le moment.
                            </div>
                        @endforelse
                    </div>
                </div>

                {{-- Chart.js UMD --}}
                <script>
                    (function loadAndInitDonut() {
                        const script = document.createElement('script');
                        script.src = "https://cdn.jsdelivr.net/npm/chart.js@4.4.6/dist/chart.umd.min.js";
                        script.crossOrigin = "anonymous";
                        script.referrerPolicy = "no-referrer";
                        script.onload = initDonut;
                        script.onerror = () => console.error('Échec de chargement de Chart.js');
                        document.head.appendChild(script);

                        function initDonut() {
                            const canvas = document.getElementById('abonnementsActifsDonut');
                            if (!canvas) return;


                            if (!labels.length) return;

                            const colors = ['#06b6d4','#8b5cf6','#f59e0b','#10b981','#ef4444','#3b82f6','#a3e635','#f97316'];

                            new Chart(canvas.getContext('2d'), {
                                type: 'doughnut',
                                data: { labels, datasets: [{ data, backgroundColor: colors.slice(0, labels.length), borderColor: '#fff', borderWidth: 2, hoverOffset: 6 }] },
                                options: {
                                    responsive: true,
                                    maintainAspectRatio: false,
                                    cutout: '60%',
                                    plugins: {
                                        legend: { display: false },
                                        tooltip: {
                                            callbacks: {
                                                label: function(ctx) {
                                                    const total = data.reduce((a,b)=>a+b,0);
                                                    const value = ctx.parsed;
                                                    const pct = total ? (value/total*100).toFixed(1) : 0;
                                                    return `${ctx.label}: ${value} (${pct}%)`;
                                                }
                                            }
                                        }
                                    }
                                }
                            });
                        }
                    });
                </script>
            </div>

            {{-- Box 2: Listes des taches personnelles --}}
            <div class="rounded-xl border border-gray-200 bg-white p-5 shadow-sm w-full md:w-[48%]">
                <h2 class="text-lg font-semibold text-gray-800 mb-2">Gestion des abonnements</h2>
                <p class="text-sm text-gray-500">Créer, modifier et gérer les abonnements des utilisateurs.</p>
            </div>

            {{-- Box 3: Taches en retard --}}
            <div class="rounded-xl border border-gray-200 bg-white p-5 shadow-sm w-full md:w-[48%]">
                <h2 class="text-lg font-semibold text-gray-800 mb-2">Gestion des rôles</h2>
                <p class="text-sm text-gray-500">Créer, assigner et administrer les rôles.</p>
            </div>



        </div>
    </div>
</div>
@endsection
