{{-- resources/views/abonnements/gest_abonnements.blade.php --}}
@extends('layouts.admin_layout') {{-- adapte si ton layout est différent --}}

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <h1 class="text-2xl sm:text-3xl font-bold mb-6">Gestion des abonnements</h1>

</div>
<div class="rounded-xl border border-gray-200 bg-white p-5 shadow-sm">
            <div class="flex items-center justify-between">
                <div>
                    <h2 class="text-lg font-semibold text-gray-800">
                        Gestion des abonnements
                    </h2>
                    
                    <p class="mt-1 text-sm text-gray-500">Liste des offres disponibles.</p>
                    
                </div>
                
                <div>
                    
            <!-- Bouton ajout -->
            <a href="{{ route('admin.abonnements.create') }}" 
           class="text-lg inline-flex items-center rounded-lg bg-indigo-600 p-2 text-white hover:bg-indigo-700">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16M20 12H4"/>
            </svg>
            </a>
                </div>
            </div>

                 <!-- Tableau simple -->
            <div class="mt-4 overflow-x-auto">
             <table class="min-w-full border-collapse">
                <thead>
                    <tr class="text-left text-sm text-gray-600">
                    <th class="border-b px-3 py-2">Abonnement</th>
                    <th class="border-b px-3 py-2 whitespace-normal w-40">Description</th>
                    <th class="border-b px-3 py-2">Prix</th>
                    </tr>
                </thead>
                <tbody class="text-sm text-gray-800">
                    @forelse($abonnements as $ab)
                    <tr class="hover:bg-gray-50">
                    <td class="border-b px-3 py-2 font-semibold">{{ $ab->abonnement }}</td>
                    <td class="border-b px-3 py-2">{{ $ab->description }}</td>
                    <td class="border-b px-3 py-2">{{ number_format($ab->prix, 2, ',', ' ') }} TND</td>
                    <td class="border-b px-3 py-2">
                <!-- Action buttons -->
                <a href="{{ route('admin.abonnements.edit', $ab->id) }}" 
                    class="text-lg inline-flex items-center rounded-lg bg-green-600 p-2 text-white hover:bg-green-700">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M15.232 5.232a2.5 2.5 0 113.536 3.536L7.5 20.036H4v-3.5L15.232 5.232z"/>
                    </svg>
                </a>

                    <button type="button"
                        class="btn-delete-ab text-lg inline-flex items-center rounded-lg bg-red-600 p-2 text-white hover:bg-red-700"
                        data-id="{{ $ab->id }}"
                        data-url="{{ route('admin.abonnements.destroy', $ab->id) }}"
                        data-name="{{ $ab->abonnement }}">
                        <!-- icône trash -->
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3m-4 0h14"/>
                        </svg>
                    </button>
                </td>
                </tr>
                    @empty
                    <tr>
                    <td colspan="4" class="px-3 py-4 text-center text-sm text-gray-500">
                        Aucune offre disponible.
                    </td>
                    </tr>
                     @endforelse
                </tbody>
             </table>
            </div>

            
        </div>
@endsection