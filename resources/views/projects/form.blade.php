@extends('layouts.app')

@section('title', isset($project) ? 'Modifier Projet' : 'Créer Projet')

@section('content')
<div class="max-w-4xl mx-auto py-8">
    <h1 class="text-3xl font-bold mb-8 text-gray-800">
        {{ isset($project) ? 'Modifier le projet' : 'Créer un projet' }}
    </h1>

    <form method="POST"
          action="{{ isset($project) ? route('projects.update', $project->id) : route('projects.store') }}"
          class="bg-white shadow-lg rounded-xl p-8 space-y-6">
        @csrf
        @if(isset($project)) @method('PUT') @endif

        <!-- Nom du projet -->
        <div>
            <label class="block text-gray-700 font-semibold mb-2">Nom du projet</label>
            <input type="text" name="nom_projet"
                   value="{{ old('nom_projet', $project->nom_projet ?? '') }}" required
                   class="w-full border rounded px-4 py-2 focus:ring-2 focus:ring-primary">
        </div>

        <!-- Description -->
        <div>
            <label class="block text-gray-700 font-semibold mb-2">Description</label>
            <textarea name="description" rows="4"
                      class="w-full border rounded px-4 py-2 focus:ring-2 focus:ring-primary">{{ old('description', $project->description ?? '') }}</textarea>
        </div>

        <!-- Dates et état -->
        <div class="grid grid-cols-3 gap-6">
            <div>
                <label class="block text-gray-700 font-semibold mb-2">Date de début</label>
                <input type="date" name="date_debut"
                       value="{{ old('date_debut', $project->date_debut ?? '') }}" required
                       class="w-full border rounded px-4 py-2 focus:ring-2 focus:ring-primary">
            </div>

            <div>
                <label class="block text-gray-700 font-semibold mb-2">Date de fin</label>
                <input type="date" name="deadline"
                       value="{{ old('deadline', $project->deadline ?? '') }}" required
                       class="w-full border rounded px-4 py-2 focus:ring-2 focus:ring-primary">
            </div>

            <div>
                <label class="block text-gray-700 font-semibold mb-2">État</label>
                <select name="id_etat" required
                        class="w-full border rounded px-4 py-2 focus:ring-2 focus:ring-primary">
                    @php
                        $etatLabels = [1=>'En cours',2=>'Terminé',3=>'En attente',4=>'Archivé'];
                    @endphp
                    @foreach($etatLabels as $id => $label)
                        <option value="{{ $id }}" {{ isset($project) && $project->id_etat == $id ? 'selected' : '' }}>
                            {{ $label }}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>

        <!-- Superviseur -->
        <div>
            <label class="block text-gray-700 font-semibold mb-2">Superviseur (obligatoire)</label>
            <select name="id_user" required
                    class="w-full border rounded px-4 py-2 focus:ring-2 focus:ring-primary">
                <option value="">-- Choisir un superviseur --</option>
                @foreach($superviseurs as $user)
                    <option value="{{ $user->id }}"
                        {{ isset($project) && $project->id_user == $user->id ? 'selected' : '' }}>
                        {{ $user->prenom }} {{ $user->nom }}
                    </option>
                @endforeach
            </select>
        </div>

        <!-- Boutons -->
        <div class="flex justify-end gap-4 mt-6">
            <a href="{{ route('projects.index') }}"
               class="px-6 py-2 rounded-lg bg-gray-300 hover:bg-gray-400 font-semibold">
               Annuler
            </a>

           <button type="submit"
        class="px-6 py-2 rounded-lg bg-blue-600 hover:bg-blue-700 text-white font-semibold shadow-lg transition">
    {{ isset($project) ? 'Modifier' : 'Créer' }}
</button>

        </div>
    </form>
</div>
@endsection
