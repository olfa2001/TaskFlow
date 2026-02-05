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

<div class="grid grid-cols-3 gap-4">
    @foreach($abonnements as $item)
      <div class="bg-[#0e3a4b] rounded-2xl p-4 shadow-lg">
        <div class="border rounded-lg p-4 shadow">
            {{-- Titre de l'abonnement --}}
            <h3 class="text-white text-3xl font-black tracking-widest mb-2">{{ $item->abonnement }}</h3>
            <div class="bg-white rounded-xl p-5">
             {{-- Features bas --}}
              <div class="text-slate-600 space-y-1 mb-5">

                {{-- Description --}}
                <p class="text-gray-600">{{ $item->description }}</p>
              </div>
            </div>

            {{-- Prix --}}
            <p class="text-[#2fd3ff] font-extrabold text-2xl mb-3">{{ $item->prix }} TND/mois</p>

            {{-- Bouton décoratif (pas d’action) --}}
            <div class="flex justify-center">
              <a href="{{ route('login') }}"
                class="mx-auto py-2 px-20 bg-black text-white rounded-full font-bold shadow " disabled aria-disabled="true">
                 Choisir
              </a>
            </div>

        </div>
      </div>
    @endforeach
</div>
</div>
@endsection
