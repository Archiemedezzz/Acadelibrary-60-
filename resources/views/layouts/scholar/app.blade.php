<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Scholar Dashboard - Acadelibrary')</title>

    <!-- Tailwind CSS & Alpine JS -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body
    class="bg-white antialiased text-black font-sans h-screen flex overflow-hidden selection:bg-black selection:text-white">

    @include('layouts.scholar.sidebar')

    <div class="flex-1 flex flex-col min-w-0 bg-white relative z-10">
        @include('layouts.scholar.topbar')
        <main class="flex-1 overflow-y-auto bg-white p-6 md:p-10">
            @yield('content')
        </main>
    </div>

</body>

</html>
