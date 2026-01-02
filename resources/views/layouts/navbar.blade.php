<header class="absolute top-0 left-0 w-full h-[80px] flex items-center px-[120px] bg-white z-50">

    <!-- Logo as link -->
    <a href="{{ route('home') }}" class="h-[50px] w-[150px]">
        <img src="{{ asset('images/Logo.png') }}" alt="TaskFlow Logo" class="h-full w-full object-contain">
    </a>

    <!-- Navigation -->
    <nav class="flex-1 flex justify-center gap-10 text-[16px]">
        <a href="{{ route('home') }}" class="text-black hover:text-cyan-500 transition">Home</a>
        <a href="#" class="text-black hover:text-cyan-500 transition">Features</a>
        <a href="{{ route('abonnements.index') }}" class="text-black hover:text-cyan-500 transition">Pricing</a>
        <a href="#" class="text-black hover:text-cyan-500 transition">Contact</a>
    </nav>

    <!-- Buttons -->
    <div class="flex gap-4">
        <!-- Login as link -->
        <a href="{{ route('login') }}" 
           class="bg-cyan-500 text-white px-6 py-2 rounded-xl text-[16px] inline-block text-center
                  hover:bg-white hover:text-cyan-500 hover:border hover:border-cyan-500 transition">
            Login
        </a>

        <!-- Sign Up -->
        <button class="border border-cyan-500 text-cyan-500 bg-white px-6 py-2 rounded-xl text-[16px]
                       hover:bg-cyan-500 hover:text-white transition">
            Sign Up
        </button>
    </div>
</header>
