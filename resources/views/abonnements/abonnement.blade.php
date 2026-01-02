
@extends('layouts.app')
@section('title', 'Offres d’abonnement')

@section('content')
<div class="max-w-6xl mx-auto px-4">

  {{-- Titre --}}
  <h2 class="text-3xl md:text-4xl font-extrabold text-slate-900 text-center mb-4">
    Choisissez l'offre qui vous convient
  </h2>

  {{-- Onglets (décoratifs, sans action) --}}
  <div class="flex justify-center gap-3 mb-6">
    <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-slate-900 text-white text-sm font-semibold shadow-inner">
      <span>👥</span> <span>Individual & small teams</span>
    </div>
    <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-teal-900 text-teal-50 text-sm font-semibold shadow-inner">
      <span>🏢</span> <span>Business & enterprises</span>
    </div>
  </div>

  {{-- Grille des 3 cartes --}}
  <div class="grid grid-cols-1 md:grid-cols-3 gap-5">

    {{-- BASIC --}}
    <div class="bg-[#0e3a4b] rounded-2xl p-4 shadow-lg">
      <div class="text-white text-3xl font-black tracking-widest mb-2">Basic</div>

      <div class="bg-white rounded-xl p-5">
        {{-- Sous-lignes --}}
        <div class="text-slate-600 space-y-1 mb-3">
          <div>Freelancers</div>
          <div>Petites équipes</div>
        </div>

        {{-- Prix --}}
        <div class="text-[#2fd3ff] font-extrabold text-2xl mb-3">Gratuit</div>

        {{-- Features bas --}}
        <div class="text-slate-600 space-y-1 mb-5">
          <div>Gestion des tâches</div>
          <div>Collaboration basique</div>
        </div>

        {{-- Bouton décoratif (pas d’action) --}}
        <button type="button" class="w-full py-2 bg-black text-white rounded-full font-bold shadow" disabled aria-disabled="true">
          Choisir
        </button>
      </div>
    </div>

    {{-- PRO --}}
    <div class="bg-[#0e3a4b] rounded-2xl p-4 shadow-lg">
      <div class="text-white text-3xl font-black tracking-widest mb-2">Pro</div>

      <div class="bg-white rounded-xl p-5">
        <div class="text-slate-600 space-y-1 mb-3">
          <div>Intégration fluide avec vos applications</div>
          <div>Rapports détaillés</div>
        </div>

        <div class="text-[#2fd3ff] font-extrabold text-2xl mb-3">10$/mois</div>

        <div class="text-slate-600 space-y-1 mb-5">
          <div>PME</div>
          <div>Équipes Agiles</div>
        </div>

        <button type="button" class="w-full py-2 bg-black text-white rounded-full font-bold shadow" disabled aria-disabled="true">
          Choisir
        </button>
      </div>
    </div>

    {{-- BUSINESS --}}
    <div class="bg-[#0e3a4b] rounded-2xl p-4 shadow-lg">
      <div class="text-white text-3xl font-black tracking-widest mb-2">Business</div>

      <div class="bg-white rounded-xl p-5">
        <div class="text-slate-600 space-y-1 mb-3">
          <div>Grandes équipes</div>
        </div>

        <div class="text-[#2fd3ff] font-extrabold text-2xl mb-3">25$/mois</div>

        <div class="text-slate-600 space-y-1 mb-5">
          <div>Automatisation tâches</div>
          <div>Gestion multiprojets</div>
          <div>Support des priorités</div>
        </div>

        <button type="button" class="w-full py-2 bg-black text-white rounded-full font-bold shadow" disabled aria-disabled="true">
          Choisir
        </button>
      </div>
    </div>

  </div>
</div>
@endsection
