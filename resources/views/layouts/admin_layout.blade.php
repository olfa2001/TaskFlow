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

    <!-- Tailwind CDN -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Be+Vietnam+Pro:wght@400;500;600&family=Inter:wght@400;500&display=swap" rel="stylesheet">

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
            <img src="{{ asset('images/Logo.png') }}" alt="Logo" class="w-40 h-auto object-contain">
        </div>

        {{-- Menu --}}
        <ul class="flex-1 space-y-4 text-gray-600 text-lg">
           @php
$menuItems = [
    ['route' => 'dashboard.admin', 'icon' => 'ic_dashboard.png', 'label' => 'Dashboard'],
    ['route' => 'admin.abonnements.gest_abonnements', 'icon' => 'ic_projects.png', 'label' => 'Gestion Abonnements'],
    ['route' => 'admin.roles.gest_roles', 'icon' => 'ic_projects.png', 'label' => 'Gestion Rôles'],
];
@endphp


            @foreach($menuItems as $item)
                @php
                    $active = $item['route'] === 'chef.settings'
                        ? Route::is('chef.settings') || Route::is('chef.profile')
                        : Route::is($item['route']);
                @endphp
                <li>
                    <a href="{{ route($item['route']) }}"
                       class="flex items-center gap-4 py-3 px-4 rounded transition
                              {{ $active ? 'bg-primary text-white' : 'hover:text-primary' }}">
                        <img src="{{ asset('images/' . $item['icon']) }}"
                             class="w-6 h-6 transition-all"
                             style="{{ $active ? 'filter: brightness(0) invert(1);' : '' }}">
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
        <header class="h-20 bg-white shadow-sm flex items-center px-8">
            <h1 class="text-xl font-semibold text-gray-800">
                @yield('page-title', 'Interface super admin')
            </h1>

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
            <div class="flex items-center gap-6">
                <div class="relative">
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
                                <a href="#" class="flex items-center gap-3 px-4 py-2 text-gray-700 hover:bg-gray-100">
                                    <img src="{{ asset('images/ic_activitylog.png') }}" class="w-5 h-5">
                                    Activity Log
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
            </div>
        </header>

        {{-- Dropdown JS --}}
        <script>
            const dropdownBtn = document.getElementById('userDropdownBtn');
            const dropdownMenu = document.getElementById('userDropdownMenu');
            dropdownBtn.addEventListener('click', () => dropdownMenu.classList.toggle('hidden'));
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

{{-- Chart.js CDN --}}
<div id="toast-root" class="fixed top-4 right-4 z-50 space-y-2"></div> <!-- Toast Container -->
<!-- debut script relié à destroy-->
<script>  
(function () {
    function getCsrfToken() {
        const el = document.querySelector('meta[name="csrf-token"]');
        return el ? el.getAttribute('content') : '';
    }

    async function deleteAbonnement(url, id, name, buttonEl) {
        const row = document.getElementById(`ab-row-${id}`);
        try {
            buttonEl.disabled = true;
            buttonEl.classList.add('opacity-50', 'cursor-not-allowed');

            const res = await fetch(url, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': getCsrfToken(),
                    'Accept': 'application/json'
                }
            });
// 🔁 Rechargement si succès (OK, 204 ou redirection 302)
if (res.ok || res.status === 204 || res.status === 302) {
    location.reload();
    return; // on stoppe la suite pour éviter l'animation inutile
}


            if (!res.ok && res.status !== 204) {
                let detail = '';
                try { detail = await res.text(); } catch (e) {}
                throw new Error(detail || `Erreur HTTP ${res.status}`);
            }

            // Supprime la ligne (effet léger)
            if (row) {
                row.classList.add('transition', 'duration-200', 'opacity-0', 'scale-95');
                setTimeout(() => row.remove(), 200);
            }

            // Toast simple (optionnel)
            console.log(`Offre "${name}" supprimée.`);

        } catch (err) {
            console.error(err);
            alert(`Suppression impossible : ${err.message || 'erreur inconnue'}`);
        } finally {
            buttonEl.disabled = false;
            buttonEl.classList.remove('opacity-50', 'cursor-not-allowed');
        }
    }

    // Délégation d'événement : un seul listener pour tous les boutons .btn-delete-ab
    document.addEventListener('click', function (e) {
        const btn = e.target.closest('.btn-delete-ab');
        if (!btn) return;

        const id = btn.dataset.id;
        const url = btn.dataset.url;
        const name = btn.dataset.name || 'cet abonnement';

        if (!url || !id) {
            alert('Données manquantes pour la suppression.');
            return;
        }

        const ok = confirm(`Voulez-vous vraiment supprimer l'abonnement "${name}" ?`);
        if (!ok) return;

        deleteAbonnement(url, id, name, btn);
    });
})();
</script>
<!-- fin script relié à destroy-->
</body>
</html>
