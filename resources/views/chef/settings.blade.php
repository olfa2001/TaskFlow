@extends('layouts.chef_layout')

@section('title', 'Edit Profile')

@section('content')
@php
    $user = Auth::user();

    $savedPhone = $user->phone ?? '';

    $knownCodes = ['+216', '+39', '+33', '+1'];

    $countryCode = '+216'; // default
    $phoneNumber = $savedPhone;

    foreach ($knownCodes as $code) {
        if (str_starts_with($savedPhone, $code)) {
            $countryCode = $code;
            $phoneNumber = substr($savedPhone, strlen($code));
            break;
        }
    }

    // Handle old() after validation error
    $countryCode = old('country_code', $countryCode);
    $phoneNumber = old('phone', $phoneNumber);
@endphp

<div class="flex gap-8">

    <!-- LEFT PROFILE CARD -->
    <div class="w-[300px] bg-white rounded-2xl shadow p-6 text-center">
        <!-- Avatar -->
        <div id="avatarContainer" class="w-48 h-64 mx-auto border-4 border-cyan-500 rounded-full overflow-hidden flex items-center justify-center cursor-pointer">
            <img id="avatarPreview" src="{{ $user->photo ? asset($user->photo) : asset('images/default-avatar.png') }}" class="w-full h-full object-contain">
        </div>

        <!-- Name -->
        <h2 class="mt-4 text-xl font-semibold">
            {{ $user->prenom ?? '—' }} {{ $user->nom ?? '' }}
        </h2>

        <!-- Profession -->
        <p class="text-sm text-gray-500 mt-1">{{ $user->profession ?? '—' }}</p>

        <!-- Info -->
        <div class="mt-6 text-left text-sm space-y-4">

            <div class="border-b border-gray-200 pb-2">
                <div class="flex items-center gap-3">
                    <!-- User role -->
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-cyan-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5.121 17.804A12.044 12.044 0 0112 15c2.485 0 4.78.756 6.879 2.056M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                    <span>{{ $user->role->role }}</span>
                </div>
            </div>

            <div class="border-b border-gray-200 pb-2">
                <div class="flex items-center gap-3">
                    <!-- Birthdate -->
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-cyan-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                    <span>{{ $user->date_naissance ?? '—' }}</span>
                </div>
            </div>

            <div class="border-b border-gray-200 pb-2">
                <div class="flex items-center gap-3">
                    <!-- Phone -->
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-cyan-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5h2l3.6 7.59a1 1 0 01-.21 1.11l-2.34 2.34a16 16 0 006.4 6.4l2.34-2.34a1 1 0 011.11-.21L19 19v2a1 1 0 01-1 1C9.163 22 2 14.837 2 6a1 1 0 011-1z"/>
                    </svg>
                    <span>{{ $user->phone ?? '—' }}</span>
                </div>
            </div>

            <div class="border-b border-gray-200 pb-2">
                <div class="flex items-center gap-3 break-all">
                    <!-- Email -->
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-cyan-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12H8m0 0l-4 4m4-4l-4-4m12 4l4-4m-4 4l4 4" />
                    </svg>
                    <span>{{ $user->email }}</span>
                </div>
            </div>

            

        </div>
    </div>

    <!-- RIGHT EDIT FORM -->
    <div class="flex-1 bg-white rounded-2xl shadow p-10">
        <h1 class="text-2xl font-semibold mb-8">Edit Profile</h1>

        @if(session('success'))
            <div class="mb-6 p-4 bg-green-100 text-green-700 rounded-lg">
                {{ session('success') }}
            </div>
        @endif

        <form method="POST" action="{{ route('chef.settings.update') }}" enctype="multipart/form-data">
            @csrf
            <div class="grid grid-cols-2 gap-6">

                <!-- Hidden avatar input -->
                <input type="file" name="photo" id="avatarInput" class="hidden" accept="image/*">

                <!-- First Name -->
                <div>
                    <label class="text-sm text-gray-500">First Name</label>
                    <input type="text" name="nom" value="{{ old('nom', $user->nom) }}" class="w-full mt-1 border rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-cyan-400">
                </div>

                <!-- Last Name -->
                <div>
                    <label class="text-sm text-gray-500">Last Name</label>
                    <input type="text" name="last_name" value="{{ old('last_name', $user->prenom) }}" class="w-full mt-1 border rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-cyan-400">
                </div>

                <!-- Email -->
                <div>
                    <label class="text-sm text-gray-500">Email</label>
                    <input type="email" name="email" value="{{ old('email', $user->email) }}" class="w-full mt-1 border rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-cyan-400">
                </div>

                 <!-- DATE OF BIRTH -->
                <div>
                    <label class="text-sm text-gray-500">Date of Birth</label>
                    <input
                        type="date"
                        name="date_naissance"
                        value="{{ old('date_naissance', $user->date_naissance) }}"
                        class="w-full mt-1 border rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-cyan-400"
                    >
                </div>

                
                <!-- Phone Number with Country Flag Dropdown -->
                <div class="col-span-2">
                    <label class="text-sm text-gray-500">Phone Number</label>
                    <div class="flex mt-1 items-center">
                        <!-- Country code dropdown -->
                        <div class="relative w-40">
                            <!-- Selected value -->
                            <button type="button" id="countryBtn"
                                class="w-full flex items-center gap-2 border border-gray-300 rounded-l-lg px-3 py-2 bg-white focus:ring-2 focus:ring-cyan-400">

                                <img id="countryFlag"
                                    src="{{ asset('images/ic_tunisia_flag.png') }}"
                                    class="w-5 h-5">

                                <span id="countryText">+216</span>
                                <svg class="ml-auto w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                </svg>
                            </button>

                            <!-- Hidden input (this is what gets submitted) -->
                            <input type="hidden" name="country_code" id="countryCodeInput" value="{{ $countryCode }}">

                            <!-- Dropdown -->
                            <div id="countryDropdown"
                                class="absolute z-20 hidden w-full bg-white border border-gray-200 rounded-lg shadow mt-1">

                                <button type="button"
                                    onclick="selectCountry('+216','ic_tunisia_flag.png')"
                                    class="flex items-center gap-2 px-3 py-2 w-full hover:bg-gray-100">
                                    <img src="{{ asset('images/ic_tunisia_flag.png') }}" class="w-5 h-5">
                                    +216
                                </button>

                                <button type="button"
                                    onclick="selectCountry('+39','ic_italy_flag.jpg')"
                                    class="flex items-center gap-2 px-3 py-2 w-full hover:bg-gray-100">
                                    <img src="{{ asset('images/ic_italy_flag.jpg') }}" class="w-5 h-5">
                                    +39
                                </button>

                                <button type="button"
                                    onclick="selectCountry('+33','ic_france_flag.png')"
                                    class="flex items-center gap-2 px-3 py-2 w-full hover:bg-gray-100">
                                    <img src="{{ asset('images/ic_france_flag.png') }}" class="w-5 h-5">
                                    +33
                                </button>

                                <button type="button"
                                    onclick="selectCountry('+1','ic_usa_flag.png')"
                                    class="flex items-center gap-2 px-3 py-2 w-full hover:bg-gray-100">
                                    <img src="{{ asset('images/ic_usa_flag.png') }}" class="w-5 h-5">
                                    +1
                                </button>
                            </div>
                        </div>




                        <!-- Phone input -->
                        <input
                            type="text"
                            name="phone"
                            value="{{ $phoneNumber }}"
                            class="flex-1 border-t border-b border-r border-gray-300 rounded-r-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-cyan-400"
                            placeholder="Phone Number"
                        />


                    </div>
                    @error('phone')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Password -->
                <div>
                    <label class="text-sm text-gray-500">New Password</label>
                    <input type="password" name="password" class="w-full mt-1 border rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-cyan-400">
                    @error('password')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Confirm Password -->
                <div>
                    <label class="text-sm text-gray-500">Confirm Password</label>
                    <input type="password" name="password_confirmation" class="w-full mt-1 border rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-cyan-400">
                    @error('password_confirmation')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

            </div>

            <!-- Save Button -->
            <div class="mt-10 text-center">
                <button type="submit" class="px-16 py-3 bg-cyan-500 text-white rounded-xl hover:bg-cyan-600 transition">Save</button>
            </div>
        </form>

        <!-- Avatar Preview Script -->
        <script>
            const avatarContainer = document.getElementById('avatarContainer');
            const avatarInput = document.getElementById('avatarInput');
            const avatarPreview = document.getElementById('avatarPreview');

            avatarContainer.addEventListener('click', () => avatarInput.click());

            avatarInput.addEventListener('change', function() {
                const file = this.files[0];
                if (file) {
                    const reader = new FileReader();
                    reader.onload = e => avatarPreview.src = e.target.result;
                    reader.readAsDataURL(file);
                }
            });
        </script>

        <script>
            const btn = document.getElementById('countryBtn');
            const dropdown = document.getElementById('countryDropdown');
            const flag = document.getElementById('countryFlag');
            const text = document.getElementById('countryText');
            const input = document.getElementById('countryCodeInput');

            btn.addEventListener('click', () => {
                dropdown.classList.toggle('hidden');
            });

            function selectCountry(code, flagFile) {
                text.textContent = code;
                flag.src = `/images/${flagFile}`;
                input.value = code;
                dropdown.classList.add('hidden');
            }

            // Load saved country on page load
            const initialMap = {
                '+216': 'ic_tunisia_flag.png',
                '+39': 'ic_italy_flag.jpg',
                '+33': 'ic_france_flag.png',
                '+1': 'ic_usa_flag.png'
            };

            if (initialMap[input.value]) {
                selectCountry(input.value, initialMap[input.value]);
            }
        </script>

    </div>

</div>
@endsection
