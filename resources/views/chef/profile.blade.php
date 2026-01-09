@extends('layouts.chef_layout')

@section('title', 'Profile')

@section('content')
<div class="space-y-8">

    {{-- HEADER WITH COVER --}}
    <div class="bg-white rounded-2xl shadow relative pb-5"> {{-- card style --}}
        
        {{-- Banner --}}
        <div class="h-48 bg-gradient-to-r from-blue-700 via-blue-500 to-purple-600 rounded-t-2xl"></div>
        
        {{-- Avatar at the bottom center --}}
        <div class="absolute left-1/2 transform -translate-x-1/2 -translate-y-1/2 top-48">
            <img src="{{ $user->photo ? asset($user->photo) : asset('images/default-avatar.png') }}" 
                alt="Avatar"
                class="w-40 h-40 rounded-full border-4 border-white object-cover shadow-lg">
        </div>
        
        {{-- NAME & ROLE --}}
        <div class="mt-24 text-center pb-6"> {{-- space under avatar for name --}}
            <h2 class="text-xl font-semibold text-gray-800">{{ $user->prenom }} {{ $user->nom }}</h2>
            <p class="text-sm text-gray-500">{{ $user->profession ?? $user->role->role ?? '—' }}</p>
        </div>
    </div>

    

    {{-- MAIN CONTENT --}}

    <div class="flex gap-8">

            {{-- LEFT: General Information --}}
            <div class="flex-1 bg-white rounded-2xl shadow p-8 space-y-6">
                <h3 class="text-lg font-semibold text-gray-700">General Information</h3>
                <p class="text-sm text-gray-400 flex items-center gap-2">
                    <span id="bioText">{{ $user->bio ?? "No bio available." }}</span>
                    <button id="editBioBtn" class="text-cyan-500 hover:text-blue-700">
                        ✎ {{-- or use an icon image --}}
                    </button>
                </p>

            {{-- Hidden input for editing --}}
                <div id="bioEditContainer" class="hidden mt-2">
                    <input type="text" id="bioInput" class="w-full p-2 border rounded" value="{{ $user->bio }}">
                    <div class="flex gap-2 mt-1">
                        <button id="saveBioBtn" class="px-3 py-1 bg-cyan-500 text-white rounded hover:bg-cyan-700">Save</button>
                        <button id="cancelBioBtn" class="px-3 py-1 bg-gray-300 rounded hover:bg-gray-400">Cancel</button>
                    </div>
                </div>


                <div class="grid grid-cols-2 gap-4 mt-4">

                    <div class="bg-gray-50 p-4 rounded-lg">
                        <p class="text-xs text-gray-400">First Name</p>
                        <p class="text-sm font-medium text-gray-800">{{ $user->prenom }}</p>
                    </div>

                    <div class="bg-gray-50 p-4 rounded-lg">
                        <p class="text-xs text-gray-400">Last Name</p>
                        <p class="text-sm font-medium text-gray-800">{{ $user->nom }}</p>
                    </div>

                    <div class="bg-gray-50 p-4 rounded-lg">
                        <p class="text-xs text-gray-400">Email</p>
                        <p class="text-sm font-medium text-gray-800">{{ $user->email }}</p>
                    </div>

                    <div class="bg-gray-50 p-4 rounded-lg">
                        <p class="text-xs text-gray-400">Phone</p>
                        <p class="text-sm font-medium text-gray-800">{{ $user->phone ?? '—' }}</p>
                    </div>

                    <div class="bg-gray-50 p-4 rounded-lg">
                        <p class="text-xs text-gray-400">Date of Birth</p>
                        <p class="text-sm font-medium text-gray-800">{{ $user->date_naissance ?? '—' }}</p>
                    </div>

                    <div class="bg-gray-50 p-4 rounded-lg">
                        <p class="text-xs text-gray-400">Role</p>
                        <p class="text-sm font-medium text-gray-800">{{ $user->role->role ?? '—' }}</p>
                    </div>

                </div>
            </div>

        
            {{-- RIGHT: Projects --}}
            <div class="w-80 bg-white rounded-2xl shadow p-6">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-lg font-semibold text-gray-700">Projects</h3>
                    <a href="{{ route('chef.projects') }}" class="text-sm text-blue-500 hover:underline">View all</a>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    @forelse($projects as $project)
                        <div class="bg-gray-50 rounded-lg p-3 shadow hover:shadow-md transition duration-200 flex flex-col justify-center items-center text-center">
                            <h4 class="text-sm font-semibold text-gray-800 mb-1 break-words">
                                {{ $project->nom_projet }}
                            </h4>
                            <p class="text-xs text-gray-500">{{ \Carbon\Carbon::parse($project->date_debut)->format('d M Y') }}</p>
                </div>
                @empty
                    <p class="text-sm text-gray-400 col-span-2 text-center">No projects assigned</p>
                @endforelse
            </div>


        </div>


    </div>
</div>
<script>
            const editBtn = document.getElementById('editBioBtn');
            const bioText = document.getElementById('bioText');
            const bioEditContainer = document.getElementById('bioEditContainer');
            const bioInput = document.getElementById('bioInput');
            const saveBtn = document.getElementById('saveBioBtn');
            const cancelBtn = document.getElementById('cancelBioBtn');

            editBtn.addEventListener('click', () => {
                bioEditContainer.classList.remove('hidden');
                bioText.classList.add('hidden');
                bioInput.focus();
            });

            cancelBtn.addEventListener('click', () => {
                bioEditContainer.classList.add('hidden');
                bioText.classList.remove('hidden');
                bioInput.value = bioText.textContent;
            });

            saveBtn.addEventListener('click', async () => {
            const bio = bioInput.value;

            try {
                const response = await fetch("{{ route('chef.updateBio') }}", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: JSON.stringify({ bio })
                });

                const data = await response.json();

                

                if(response.ok){
                    bioText.textContent = bio || "No bio available.";
                    bioEditContainer.classList.add('hidden');
                    bioText.classList.remove('hidden');
                } else {
                    console.error(data);
                    alert('Failed to update bio: ' + (data.message || 'Unknown error'));
                }
            } catch(e){
                console.error(e);
                alert('Failed to update bio: ' + e.message);
            }
        });

</script>
@endsection
