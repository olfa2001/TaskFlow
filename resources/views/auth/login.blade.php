@extends('layouts.app')

@section('title', 'Login - TaskFlow')

@section('content')

<div class="w-full max-w-[1600px] mx-auto h-[800px] flex rounded-[60px] mt-[100px]">

    <!-- LEFT: LOGIN FORM -->
    <div class="w-full flex justify-center items-center bg-white">
        <div class="w-[500px] p-12 bg-white rounded-[60px] shadow-2xl shadow-black/20">

            <h1 class="text-5xl font-bold text-zinc-900 mb-12 text-center font-vietnam">
                Login
            </h1>

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <!-- EMAIL -->
                <label for="email" class="block text-2xl mb-3 text-zinc-900 font-vietnam">
                    Email
                </label>
                <div class="w-full mb-6">
                    <div class="relative">
                        <input
                            type="email"
                            name="email"
                            id="email"
                            value="{{ old('email') }}"
                            required
                            class="w-full bg-transparent border-b-2 border-zinc-400
                                   py-3 pr-12 text-lg text-zinc-900
                                   focus:outline-none focus:border-cyan-500"
                        />
                        <svg class="absolute right-3 top-1/2 -translate-y-1/2 w-6 h-6 text-zinc-700"
                             fill="none" stroke="currentColor" stroke-width="1.5"
                             viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                  d="M21.75 6.75v10.5a2.25 2.25 0 0 1-2.25 2.25H4.5
                                     A2.25 2.25 0 0 1 2.25 17.25V6.75
                                     m19.5 0A2.25 2.25 0 0 0 19.5 4.5H4.5
                                     A2.25 2.25 0 0 0 2.25 6.75
                                     m19.5 0-9.75 6.75L2.25 6.75" />
                        </svg>
                    </div>
                    @error('email')
                        <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                    @enderror
                </div>

                <!-- PASSWORD -->
                <label for="password" class="block text-2xl mb-3 text-zinc-900 font-vietnam">
                    Password
                </label>
                <div class="w-full mb-6">
                    <div class="relative">
                        <input
                            type="password"
                            name="password"
                            id="password"
                            required
                            class="w-full bg-transparent border-b-2 border-zinc-400
                                   py-3 pr-12 text-lg text-zinc-900
                                   focus:outline-none focus:border-cyan-500"
                        />
                        <svg class="absolute right-3 top-1/2 -translate-y-1/2 w-6 h-6 text-zinc-700"
                             fill="none" stroke="currentColor" stroke-width="1.5"
                             viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                  d="M16.5 10.5V7.875a4.5 4.5 0 1 0-9 0V10.5
                                     m-.75 0h10.5
                                     a2.25 2.25 0 0 1 2.25 2.25v6
                                     a2.25 2.25 0 0 1-2.25 2.25H6
                                     a2.25 2.25 0 0 1-2.25-2.25v-6
                                     a2.25 2.25 0 0 1 2.25-2.25Z" />
                        </svg>
                    </div>
                    @error('password')
                        <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                    @enderror
                </div>

                <!-- FORGOT -->
                <div class="text-right mb-6">
                    <a href="#" class="text-sky-900 text-lg font-medium hover:underline">
                        Forgot Password?
                    </a>
                </div>

                <!-- SUBMIT -->
                <button type="submit"
                        class="w-full py-4 bg-cyan-500 text-white text-2xl font-bold
                               rounded-lg hover:bg-sky-700 transition">
                    Login
                </button>
            </form>

            <!-- REGISTER -->
            <div class="mt-6 text-center text-lg">
                <span class="text-zinc-900">Don’t have an account? </span>

<a href="{{ route('register') }}" class="text-sky-900 font-bold">
    Register
</a>


            </div>
        </div>
    </div>

    <!-- RIGHT IMAGE -->
    <div class="w-full flex items-center justify-center -ml-20">
        <img src="{{ asset('images/login-right.png') }}" class="h-[520px] object-contain">
    </div>

</div>

@endsection
