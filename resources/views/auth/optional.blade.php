@extends('layouts.app')

@section('title', 'Optional Info - TaskFlow')

@section('content')
<div class="w-full max-w-[1600px] mx-auto h-[900px] flex rounded-[60px] mt-[100px]">
    <div class="w-full flex justify-center items-center bg-white">
        <div class="w-[520px] p-12 bg-white rounded-[60px] shadow-2xl shadow-black/20">
            <h1 class="text-5xl font-bold text-zinc-900 mb-10 text-center">Optional Information</h1>

            <form method="POST" action="{{ route('register.optional.store', ['user_id' => $user->id]) }}" enctype="multipart/form-data">
                @csrf

                <label class="block text-xl mb-2">Téléphone</label>
                <input type="text" name="phone" value="{{ old('phone') }}" class="w-full border-b-2 py-2 mb-4">

                <label class="block text-xl mb-2">Profession</label>
                <input type="text" name="profession" value="{{ old('profession') }}" class="w-full border-b-2 py-2 mb-4">

                <label class="block text-xl mb-2">Bio</label>
                <textarea name="bio" class="w-full border-b-2 py-2 mb-4">{{ old('bio') }}</textarea>

                <label class="block text-xl mb-2">Photo de profil</label>
                <input type="file" name="photo" class="w-full mb-4">

                <label class="block text-xl mb-2">Abonnement *</label>
                <select name="id_abonnement" required class="w-full border-b-2 py-2 mb-4">
                    <option value="">-- Choisir --</option>
                    @foreach($abonnements as $abonnement)
                        <option value="{{ $abonnement->id }}">
                            {{ $abonnement->abonnement }} ({{ $abonnement->prix }} DT)
                        </option>
                    @endforeach
                </select>

                <button type="submit" class="w-full py-4 bg-cyan-500 text-white text-2xl font-bold rounded-lg hover:bg-sky-700 transition">
                    Save
                </button>
            </form>
        </div>
    </div>
</div>
@endsection
