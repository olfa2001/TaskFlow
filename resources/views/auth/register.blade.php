@extends('layouts.app')

@section('title', 'Register - TaskFlow')

@section('content')
<div class="w-full max-w-[1600px] mx-auto h-[900px] flex rounded-[60px] mt-[100px]">
    <div class="w-full flex justify-center items-center bg-white">
        <div class="w-[520px] p-12 bg-white rounded-[60px] shadow-2xl shadow-black/20">
            <h1 class="text-5xl font-bold text-zinc-900 mb-10 text-center">Register</h1>

            @if ($errors->any())
                <div class="mb-6 text-red-600">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>- {{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('register.store') }}">
                @csrf

                <label class="block text-xl mb-2">Prénom *</label>
                <input type="text" name="prenom" value="{{ old('prenom') }}" required class="w-full border-b-2 py-2 mb-4">

                <label class="block text-xl mb-2">Nom</label>
                <input type="text" name="nom" value="{{ old('nom') }}" class="w-full border-b-2 py-2 mb-4">

                <label class="block text-xl mb-2">Email *</label>
                <input type="email" name="email" value="{{ old('email') }}" required class="w-full border-b-2 py-2 mb-4">

                <label class="block text-xl mb-2">Password *</label>
                <input type="password" name="password" required class="w-full border-b-2 py-2 mb-4">

                <label class="block text-xl mb-2">Confirm Password *</label>
                <input type="password" name="password_confirmation" required class="w-full border-b-2 py-2 mb-4">

                <input type="hidden" name="id_role" value="2">

                <button type="submit" class="w-full py-4 bg-cyan-500 text-white text-2xl font-bold rounded-lg hover:bg-sky-700 transition">
                    Next
                </button>
            </form>
        </div>
    </div>
</div>
@endsection
