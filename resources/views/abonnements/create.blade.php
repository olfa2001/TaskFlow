@extends('layouts.app')

@section('title', 'Créer une offre d’abonnement')

@section('content')
  <div class="max-w-2xl mx-auto">
    {{-- Titre --}}
    <div class="mb-6">
      <h1 class="text-2xl font-semibold text-gray-900">Créer une offre d’abonnement</h1>
      <p class="text-sm text-gray-500 mt-1">Renseigne les informations de l’offre puis enregistre.</p>
    </div>

    {{-- Messages d'erreur globaux --}}
    @if ($errors->any())
      <div class="mb-4 rounded-md bg-red-50 p-4 border border-red-200">
        <div class="flex">
          <svg class="h-5 w-5 text-red-600 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
              d="M12 9v2m0 4h.01M4.93 4.93l14.14 14.14M12 2a10 10 0 100 20 10 10 0 000-20z" />
          </svg>
          <div class="ml-3 text-sm text-red-800">
            <p class="font-medium">Veuillez corriger les erreurs ci-dessous.</p>
          </div>
        </div>
      </div>
    @endif

    {{-- Formulaire de création --}}
    <form method="POST" action="{{ route('admin.abonnements.store') }}">
      @csrf

      {{-- Nom de l’abonnement --}}
      <div>
        <label for="abonnement" class="block text-sm font-medium text-gray-700">
          Nom de l’abonnement <span class="text-red-500">*</span>
        </label>
        <input
          type="text"
          name="abonnement"
          id="abonnement"
          maxlength="150"
          value="{{ old('abonnement') }}"
          class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500
                 @error('abonnement') border-red-300 focus:border-red-500 focus:ring-red-500 @enderror"
          placeholder="Ex : Standard, Premium, Entreprise" required>
        @error('abonnement')
          <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
        @enderror
      </div>

      {{-- Description (optionnelle) --}}
      <div>
        <label for="description" class="block text-sm font-medium text-gray-700">
          Description <span class="text-gray-400">(optionnel)</span>
        </label>
        <textarea
          name="description"
          id="description"
          rows="4"
          maxlength="500"
          class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500
                 @error('description') border-red-300 focus:border-red-500 focus:ring-red-500 @enderror"
          placeholder="Décris brièvement l’offre (inclus, limites, conditions)…">{{ old('description') }}</textarea>
        @error('description')
          <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
        @enderror
      </div>

      {{-- Prix --}}
      <div>
        <label for="prix" class="block text-sm font-medium text-gray-700">
          Prix (TND) <span class="text-red-500">*</span>
        </label>
        <input
          type="number"
          name="prix"
          id="prix"
          step="0.01"
          min="0"
          value="{{ old('prix') }}"
          class="mt-1 block w-64 rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500
                 @error('prix') border-red-300 focus:border-red-500 focus:ring-red-500 @enderror"
          placeholder="0.00" required>
        @error('prix')
          <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
        @enderror
      </div>

      {{-- Actions --}}
      <div class="flex items-center gap-3 pt-2">
        <button type="submit"
                class="inline-flex items-center rounded-md bg-indigo-600 px-4 py-2 text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500">
          Enregistrer
        </button>

        <a href="{{ route('dashboard.admin') }}" class="inline-flex items-center rounded-md bg-red-500 px-4 py-2 text-white hover:bg-red-600 focus:outline-none focus:ring-2 focus:ring-gray-500">
          Annuler
        </a>
      </div>
    </form>
  </div>
