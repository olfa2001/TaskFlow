<!DOCTYPE html>
<html lang="fr">
@php
    $user = auth()->user();
@endphp

<head>
    <meta charset="UTF-8" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>@yield('title', 'TaskFlow')</title>

    {{-- Tailwind --}}
    <script src="https://cdn.tailwindcss.com"></script>

    {{-- Google Fonts --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Be+Vietnam+Pro:wght@400;500;600&family=Inter:wght@400;500&display=swap" rel="stylesheet">

    {{-- Chart --}}
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: { primary: '#238899' },
                    fontFamily: {
                        vietnam: ['Be Vietnam Pro', 'sans-serif'],
                        inter: ['Inter', 'sans-serif'],
                    },
                },
            }
        }
    </script>
</head>

<body class="bg-gray-100 font-vietnam min-h-screen">

<div class="flex h-screen">

    {{-- SIDEBAR --}}
    <aside class="w-72 bg-white shadow-lg flex flex-col px-8 py-6">

        {{-- Logo --}}
        <div class="mb-12 flex justify-center">
            <img src="{{ asset('images/Logo.png') }}" class="w-40">
        </div>

        {{-- MENU --}}
        <ul class="flex-1 space-y-4 text-gray-600 text-lg">
            @php
                $menuItems = [
                    ['route' => 'dashboard.contributeur', 'icon' => 'ic_dashboard.png', 'label' => 'Dashboard'],
                    ['route' => 'projects.index', 'icon' => 'ic_projects.png', 'label' => 'Projets'],
                    ['route' => 'tasks.index', 'icon' => 'ic_tasks.png', 'label' => 'Taches'],
                    ['route' => 'equipe', 'icon' => 'ic_teams.png', 'label' => 'Groupes'],
                    ['route' => 'contributeur.reports', 'icon' => 'ic_reports.png', 'label' => 'Raports'],
                    ['route' => 'contributeur.messages', 'icon' => 'ic_messages.png', 'label' => 'Messages'],
                    ['route' => 'contributeur.settings', 'icon' => 'ic_settings.png', 'label' => 'Paramétres'],
                ];
            @endphp

            @foreach ($menuItems as $item)
                @php
                    $active = $item['route'] === 'contributeur.settings'
                        ? Route::is('contributeur.settings') || Route::is('contributeur.profile')
                        : Route::is($item['route']);
                @endphp

                                <li>
                    <a href="{{ route($item['route']) }}"
                       class="flex items-center gap-4 py-3 px-4 rounded transition
                              {{ $active ? 'bg-primary text-white' : 'hover:text-primary' }}">

                            <img src="{{ asset('images/' . $item['icon']) }}"
                            class="w-6 h-6 transition-all {{ $active ? 'brightness-0 invert' : '' }}">

                        {{ $item['label'] }}
                    </a>
                </li>

            @endforeach

            {{-- LOGOUT --}}
            <li>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit"
                            class="flex items-center gap-4 py-3 px-4 w-full hover:text-primary">
                        <img src="{{ asset('images/ic_signout.png') }}" class="w-6 h-6">
                        Se déconnecter
                    </button>
                </form>
            </li>
        </ul>
    </aside>

    {{-- MAIN --}}
    <div class="flex-1 flex flex-col">

        {{-- TOP BAR --}}
        <header class="h-20 bg-white shadow-sm flex items-center px-8">
            <h1 class="text-xl font-semibold text-gray-800">
                @yield('page-title', 'Dashboard')
            </h1>

            {{-- SEARCH --}}
            <div class="flex-1 flex justify-center">
                <div class="relative w-[420px]">
                    <span class="absolute inset-y-0 left-4 flex items-center">
                        <img src="{{ asset('images/ic_magnifier.png') }}" class="w-6 h-6">
                    </span>
                    <input type="text" placeholder="Search..."
                           class="w-full pl-12 pr-4 py-3 rounded-full bg-gray-100 focus:ring-2 focus:ring-primary">
                </div>
            </div>

            {{-- USER --}}
            <div class="relative">
                <button id="userDropdownBtn" class="flex items-center gap-3">
                    <img src="{{ $user && $user->photo ? asset($user->photo) : asset('images/default-avatar.png') }}"
                         class="w-10 h-10 rounded-full">
                    <div>
                        <p class="text-sm font-semibold">{{ $user->prenom }} {{ $user->nom }}</p>
                        <p class="text-xs text-gray-400">Contributeur</p>
                    </div>
                    <span>▾</span>
                </button>

                <div id="userDropdownMenu"
                     class="absolute right-0 mt-2 w-56 bg-white rounded-lg shadow-lg hidden">
                    <ul class="py-2">
                        <li>
                            <a href="{{ route('superviseur.settings') }}"
                               class="block px-4 py-2 hover:bg-gray-100">
                                Account settings
                            </a>
                        </li>
                        <li>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button class="w-full text-left px-4 py-2 hover:bg-gray-100">
                                    Logout
                                </button>
                            </form>
                        </li>
                    </ul>
                </div>
            </div>
        </header>

        {{-- DROPDOWN SCRIPT --}}
        <script>
            const btn = document.getElementById('userDropdownBtn');
            const menu = document.getElementById('userDropdownMenu');
            btn.addEventListener('click', e => {
                e.stopPropagation();
                menu.classList.toggle('hidden');
            });
            document.addEventListener('click', () => menu.classList.add('hidden'));
        </script>

        {{-- CONTENT --}}
        <main class="flex-1 p-6 overflow-y-auto">
            @yield('content')
        </main>

    </div>
</div>

</body>
</html>
