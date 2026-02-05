@extends('layouts.app')

@section('title', 'Home - TaskFlow')

@section('content')

    <!-- Hero Section -->
      <section class="relative h-[700px] pt-[180px] px-[120px]">

        <h1 class="text-[56px] font-medium leading-[72px] text-black max-w-[720px]">
          Planifiez Mieux, <br> Avancez Plus Vite <br> Avec TaskFlow.
        </h1>

        <p class="mt-6 text-[18px] leading-[28px] text-gray-600 max-w-[640px]">
          Votre espace pour créer, planifier et livrer.
          <br> Une plateforme. Tous vos projets.
        </p>

        <div class="mt-10 flex gap-6">
            <!-- Get Started Button -->
            <button class="bg-cyan-500 text-white px-10 py-4 rounded-xl text-[16px]
                          hover:bg-white hover:text-cyan-500 hover:border hover:border-cyan-500 transition">
                Commencer
            </button>

            <!-- Login Link as Button -->
            <a href="{{ route('login') }}"
              class="border border-black px-10 py-4 rounded-xl text-[16px] inline-block text-center
                      hover:bg-cyan-500 hover:text-white transition">
                connexion
            </a>
        </div>


        <!-- Hero Image -->
        <div class="absolute right-[120px] top-[200px] w-[420px] h-[420px] rounded-xl overflow-hidden">
            <img src="{{ asset('images/hero.png') }}" alt="Hero Image" class="w-full h-full object-cover">
        </div>


      </section>

      <section class="py-12 px-8 bg-white flex justify-center">
        <div class=" rounded-xl overflow-hidden">
            <img src="{{ asset('images/features.png') }}" alt="Section Image" class="w-full h-full object-cover">
        </div>
    </section>


    <!-- Features Section -->
    <section class="relative px-[120px] py-[120px] grid grid-cols-3 gap-[40px]">
        <div class="p-8 border rounded-2xl">
            <h3 class="text-xl font-medium mb-3">Gestion Simple</h3>
            <p class="text-gray-600">Organisez vos tâches et projets sans effort.</p>
        </div>
        <div class="p-8 border rounded-2xl">
            <h3 class="text-xl font-medium mb-3">Collaboration</h3>
            <p class="text-gray-600">Travaillez en équipe en temps réel.</p>
        </div>
        <div class="p-8 border rounded-2xl">
            <h3 class="text-xl font-medium mb-3">Suivi Intelligent</h3>
            <p class="text-gray-600">Visualisez l’avancement facilement.</p>
        </div>
    </section>

@endsection




