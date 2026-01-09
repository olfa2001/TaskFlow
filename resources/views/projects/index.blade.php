@extends('layouts.chef_layout')

@section('title', 'Mes Projets')

@section('content')
<div class="max-w-6xl mx-auto py-6">

    <!-- Navbar filtres -->
    <div class="flex flex-wrap gap-3 mb-8">
        <a href="{{ route('projects.create') }}"
           class="px-5 py-2 bg-primary text-white rounded-lg shadow hover:bg-primary/90 font-semibold">
           + Add Project
        </a>

        <a href="{{ route('projects.index', ['filter'=>'all']) }}"
           class="px-5 py-2 rounded-lg font-medium {{ $filter=='all' ? 'bg-primary text-white' : 'bg-gray-200 text-gray-700' }}">
           All
        </a>

        <a href="{{ route('projects.index', ['filter'=>'favorites']) }}"
           class="px-5 py-2 rounded-lg font-medium {{ $filter=='favorites' ? 'bg-primary text-white' : 'bg-gray-200 text-gray-700' }}">
           ⭐ Favorites
        </a>

        <a href="{{ route('projects.index', ['filter'=>'archived']) }}"
           class="px-5 py-2 rounded-lg font-medium {{ $filter=='archived' ? 'bg-primary text-white' : 'bg-gray-200 text-gray-700' }}">
           Archived
        </a>
    </div>

    @php
        $etatLabels = [
            1 => 'En cours',
            2 => 'Terminé',
            3 => 'En attente',
            4 => 'Archivé'
        ];

        // Filtrer les projets pour All et exclure Archivé
        $projectsByEtat = $projects
            ->when($filter=='all', fn($c) => $c->whereNotIn('id_etat', [4]))
            ->groupBy('id_etat');
    @endphp

    @foreach($etatLabels as $etatId => $label)
        @if(isset($projectsByEtat[$etatId]) && ($filter !== 'archived' || $etatId == 4))
        <section class="mb-10">
            <h2 class="text-2xl font-semibold mb-5">{{ $label }}</h2>

            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
                @foreach($projectsByEtat[$etatId] as $project)
                <div class="bg-white rounded-xl shadow-md p-6 flex flex-col justify-between hover:shadow-lg transition">

                    <!-- CONTENU CENTRÉ -->
                    <div class="space-y-3 text-center">

                        <!-- Dates -->
                        <div class="text-sm text-gray-500 font-medium">
                            {{ $project->date_debut ? \Carbon\Carbon::parse($project->date_debut)->format('d F Y') : '—' }}
                            -
                            {{ $project->deadline ? \Carbon\Carbon::parse($project->deadline)->format('d F Y') : '—' }}
                        </div>

                        <!-- Nom du projet -->
                        <h3 class="text-lg font-bold text-gray-800">
                            {{ $project->nom_projet }}
                        </h3>

                        <!-- Description -->
                        <p class="text-gray-600 text-sm">
                            {{ $project->description ?? '—' }}
                        </p>

                        <!-- Progression + Reste pour tous les états sauf Archivé -->
                        @php
                            $progress = 0;
                            $restText = '';
                            $restColor = '#22c55e';
                            if($etatId != 4 && $project->date_debut && $project->deadline){
                                $start = \Carbon\Carbon::parse($project->date_debut);
                                $end = \Carbon\Carbon::parse($project->deadline);
                                $now = now();

                                // Progression seulement pour en cours
                                if($etatId == 1){
                                    if($now->lessThan($start)) $progress=0;
                                    elseif($now->greaterThan($end)) $progress=100;
                                    else {
                                        $total = $start->diffInSeconds($end);
                                        $elapsed = $start->diffInSeconds($now);
                                        $progress = round(($elapsed/$total)*100);
                                    }
                                }

                                // Reste
                                $daysLeft = $now->diffInDays($end, false);
                                if($daysLeft >= 30){
                                    $restText = 'Il reste '.ceil($daysLeft/30).' mois';
                                    $restColor = '#22c55e';
                                } elseif($daysLeft >= 7){
                                    $restText = 'Il reste '.ceil($daysLeft/7).' semaines';
                                    $restColor = '#f59e0b';
                                } else {
                                    $restText = 'Il reste '.$daysLeft.' jours';
                                    $restColor = '#7f1d1d';
                                }
                            }
                        @endphp

                        @if($etatId == 1)
                        <!-- Progress bar -->
                        <div class="mt-4 px-2">
                            <div class="flex justify-between text-xs font-semibold text-gray-600 mb-1">
                                <span>Progress</span>
                                <span>{{ $progress }}%</span>
                            </div>
                            <div class="w-full bg-gray-200 rounded-full h-2 overflow-hidden mb-1">
                                <div class="h-2 rounded-full transition-all duration-500"
                                     style="width: {{ $progress }}%; background-color: {{ $restColor }};">
                                </div>
                            </div>
                            <hr class="mb-1">
                        </div>
                        @endif

                        @if($etatId != 4)
                        <!-- Reste + Superviseurs -->
                        <div class="flex justify-between items-center mt-2 px-2">

                            <!-- Reste -->
                            <span class="text-xs font-semibold text-white px-2 py-1 rounded"
                                  style="background-color: {{ $restColor }}">
                                {{ $restText }}
                            </span>

                            <!-- Superviseurs + bouton + -->
                            <div class="flex items-center justify-center gap-2 mt-2 relative">

                                <!-- Superviseur principal -->
                                <img src="{{ $project->superviseur?->photo ? asset('images/' . $project->superviseur->photo) : asset('images/default-avatar.png') }}"
                                     class="w-8 h-8 rounded-full border-2 border-white shadow-sm"
                                     title="{{ $project->superviseur?->prenom ?? '—' }}">

                                <!-- Autres superviseurs ajoutés -->
                                @foreach($project->other_superviseurs ?? [] as $other_id)
                                    @php $other = $users->find($other_id); @endphp
                                    @if($other)
                                        <img src="{{ $other->photo ? asset('images/' . $other->photo) : asset('images/default-avatar.png') }}"
                                             class="w-8 h-8 rounded-full border-2 border-white shadow-sm"
                                             title="{{ $other->prenom }}">
                                    @endif
                                @endforeach

                                <!-- Bouton + -->
                                <button onclick="document.getElementById('select-{{ $project->id }}').classList.toggle('hidden')"
                                        class="text-primary font-bold text-lg ml-1">+</button>

                                <!-- Formulaire flottant -->
                                <div id="select-{{ $project->id }}" class="hidden absolute bg-white shadow-md p-2 rounded mt-10 z-50">
                                    <form action="{{ route('projects.updateSupervisor', $project->id) }}" method="POST">
                                        @csrf
                                        <select name="superviseur_id" class="p-1 border rounded w-full">
                                            @foreach($users as $user)
                                                @if($user->role->role === 'Superviseur')
                                                    <option value="{{ $user->id }}">{{ $user->prenom }}</option>
                                                @endif
                                            @endforeach
                                        </select>
                                        <button type="submit" class="bg-primary text-white px-2 py-1 rounded mt-1 w-full">Ajouter</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                        @endif

                    </div>

                    <!-- ACTIONS -->
                    @if($etatId != 4)
                    <div class="flex justify-center items-center gap-5 mt-5 pt-4 border-t">

                        <!-- FAVORI -->
                        <form method="POST" action="{{ route('projects.favorite', $project->id) }}">
                            @csrf
                            <button class="text-xl">{{ $project->is_favorite ? '⭐' : '☆' }}</button>
                        </form>

                        <!-- EDIT -->
                        <a href="{{ route('projects.edit', $project->id) }}" class="text-blue-500 font-semibold">✏️</a>

                        <!-- ARCHIVE -->
                        <form method="POST" action="{{ route('projects.archive', $project->id) }}">
                            @csrf
                            <button class="text-yellow-500 font-semibold">📦</button>
                        </form>

                        <!-- DELETE avec SweetAlert -->
                        <form method="POST" action="{{ route('projects.destroy', $project->id) }}" class="delete-form">
                            @csrf
                            @method('DELETE')
                            <button type="button" class="text-red-500 font-semibold delete-btn">🗑️</button>
                        </form>

                    </div>
                    @endif

                </div>
                @endforeach
            </div>
        </section>
        @endif
    @endforeach

</div>

<!-- SweetAlert script -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
// SweetAlert delete
document.querySelectorAll('.delete-btn').forEach(button => {
    button.addEventListener('click', function() {
        const form = this.closest('form');
        Swal.fire({
            title: 'Êtes-vous sûr ?',
            text: "Vous ne pourrez pas revenir en arrière !",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Oui, supprimer !',
            cancelButtonText: 'Annuler'
        }).then((result) => {
            if (result.isConfirmed) {
                form.submit();
            }
        });
    });
});
</script>
@endsection
