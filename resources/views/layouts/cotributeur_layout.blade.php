<!DOCTYPE html>
<html lang="fr">
@php
    $user = auth()->user();
@endphp

<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'TaskFlow')</title>

    <!-- Tailwind CDN -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Be+Vietnam+Pro:wght@400;500;600&family=Inter:wght@400;500&display=swap" rel="stylesheet">

    <!-- Chart.js CDN -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.6/dist/chart.umd.min.js"></script>

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: { primary: '#238899' },
                    fontFamily: {
                        vietnam: ['Be Vietnam Pro', 'sans-serif'],
                        inter: ['Inter', 'sans-serif'],
                    },
                }
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
            <img src="{{ asset('images/Logo.png') }}" alt="Logo" class="w-40 h-auto object-contain">
        </div>

        {{-- Menu --}}
        <ul class="flex-1 space-y-4 text-gray-600 text-lg">
            @php
                $menuItems = [
                    ['route' => 'dashboard.admin', 'icon' => 'ic_dashboard.png', 'label' => 'Dashboard'],
                    ['route' => 'admin.abonnements.gest_abonnements', 'icon' => 'ic_projects.png', 'label' => 'Gestion Abonnements'],
                    ['route' => 'admin.roles.gest_roles', 'icon' => 'ic_teams.png', 'label' => 'Gestion Rôles'],
                    ['route' => 'admin.utilisateurs.index', 'icon' => 'ic_teams.png', 'label' => 'Gestion Utilisateurs'],
                    ['route' => 'admin.settings', 'icon' => 'ic_settings.png', 'label' => 'Settings'],
                ];
            @endphp

            @foreach($menuItems as $item)
                @php
                    $active = Route::is($item['route']);
                @endphp
                <li>
                    <a href="{{ route($item['route']) }}"
                       class="flex items-center gap-4 py-3 px-4 rounded transition
                       {{ $active ? 'bg-primary text-white' : 'hover:text-primary' }}">
                        <img src="{{ asset('images/' . $item['icon']) }}" class="w-6 h-6 transition-all"

                        {{ $item['label'] }}
</a>
                </li>
            @endforeach

            {{-- Sign Out --}}
            <li>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit"
                            class="flex items-center gap-4 py-3 px-4 w-full text-gray-600 hover:text-primary rounded transition">
                        <img src="{{ asset('images/ic_signout.png') }}" class="w-6 h-6 transition-all">
                        Sign Out
                    </button>
                </form>
            </li>
        </ul>
    </aside>

    {{-- MAIN AREA --}}
    <div class="flex-1 flex flex-col">

        {{-- TOP MENU --}}
        <header class="h-20 bg-white shadow-sm flex items-center px-8 justify-between">
            <h1 class="text-xl font-semibold text-gray-800">@yield('page-title', 'Interface Super Admin')</h1>

            {{-- SEARCH --}}
            <div class="flex-1 flex justify-center">
                <div class="relative w-[420px]">
                    <span class="absolute inset-y-0 left-4 flex items-center text-gray-400">
                        <img src="{{ asset('images/ic_magnifier.png') }}" class="w-6 h-6">
                    </span>
                    <input type="text" placeholder="Search here..."
                           class="w-full pl-12 pr-4 py-3 rounded-full bg-gray-100 text-sm focus:outline-none focus:ring-2 focus:ring-primary" />
                </div>
            </div>

            {{-- USER INFO --}}
            <div class="flex items-center gap-6 relative">
                <button id="userDropdownBtn" class="flex items-center gap-3 cursor-pointer focus:outline-none">
                    <img src="{{ $user && $user->photo ? asset($user->photo) : asset('images/default-avatar.png') }}"
                         class="w-10 h-10 rounded-full object-cover">
                    <div class="leading-tight">
                        <p class="text-sm font-semibold text-gray-800">
                            {{ $user->prenom ?? '' }} {{ $user->nom ?? '' }}
                        </p>
                        <p class="text-xs text-gray-400">Superadmin</p>
                    </div>
                    <span class="text-gray-400">▾</span>
                </button>

                <div id="userDropdownMenu"
                     class="absolute right-0 mt-2 w-56 bg-white rounded-lg shadow-lg border border-gray-200 z-50 hidden">
                    <ul class="py-2">
                        <li>
                            <a href="{{ route('chef.settings') }}"
                               class="flex items-center gap-3 px-4 py-2 text-gray-700 hover:bg-gray-100">
                                <img src="{{ asset('images/ic_manageaccount.png') }}" class="w-5 h-5">
                                Manage Account
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('chef.profile') }}"
                               class="flex items-center gap-3 px-4 py-2 text-gray-700 hover:bg-gray-100">
                                <img src="{{ asset('images/ic_showprofile.png') }}" class="w-5 h-5">
                                Show Profile
                            </a>
                        </li>
                        <li>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="flex items-center gap-3 px-4 py-2 w-full text-gray-700 hover:bg-gray-100">
                                    <img src="{{ asset('images/ic_logout.png') }}" class="w-5 h-5">
                                    Log Out
                                </button>
                            </form>
                        </li>
                    </ul>
                </div>
            </div>
        </header>

        {{-- Dropdown JS --}}
        <script>
            const dropdownBtn = document.getElementById('userDropdownBtn');
            const dropdownMenu = document.getElementById('userDropdownMenu');

            dropdownBtn.addEventListener('click', e => {
                e.stopPropagation();
                dropdownMenu.classList.toggle('hidden');
            });

            document.addEventListener('click', e => {
                if (!dropdownBtn.contains(e.target) && !dropdownMenu.contains(e.target)) {
                    dropdownMenu.classList.add('hidden');
                }
            });
        </script>

        {{-- CONTENT --}}
        <main class="flex-1 p-6 overflow-y-auto">
            @yield('content')
        </main>
    </div>
</div>

</body>
</html>
