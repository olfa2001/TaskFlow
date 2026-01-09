<!DOCTYPE html>
<html lang="fr">
<head>
    <meta name="csrf-token" content="{{ csrf_token() }}"> <!-- CSRF Token -->
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>@yield('title', 'TaskFlow')</title>

    <!-- Tailwind CDN -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Be+Vietnam+Pro:wght@400;500;600&family=Inter:wght@400;500&display=swap" rel="stylesheet">

    <!-- Tailwind Config -->
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        vietnam: ['Be Vietnam Pro', 'sans-serif'],
                        inter: ['Inter', 'sans-serif'],
                    },
                },
            },
        }
    </script>
</head>
<body class="bg-white-100 font-vietnam">

    <!-- NAVBAR -->
    @include('layouts.navbar')

    <!-- PAGE CONTENT -->
    <div class="min-h-screen overflow-x-auto pt-[100px]">
        @yield('content')
    </div>

    <!-- FOOTER -->
    @include('layouts.footer')
    

<script src="https://cdn.jsdelivr.net/npm/chart.js@art.umd.min.js</script>
@stack('scripts')

    
</body>
</html>
