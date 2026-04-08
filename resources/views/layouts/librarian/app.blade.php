<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Librarian Dashboard - Acadelibrary')</title>

    <!-- Tailwind CSS & Alpine JS -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body
    class="bg-white antialiased text-black font-sans h-screen flex overflow-hidden selection:bg-black selection:text-white">

    @include('layouts.librarian.sidebar')

    <div class="flex-1 flex flex-col min-w-0 bg-white relative z-10">
        @include('layouts.librarian.topbar')
        <main class="flex-1 overflow-y-auto bg-white p-6 md:p-6">
            @yield('content')
        </main>
    </div>

    <script>
        document.addEventListener('click', function(event) {
            const dropdowns = document.querySelectorAll('.filter-dropdown-wrapper');

            dropdowns.forEach(function(dropdown) {
                const toggle = dropdown.querySelector('.filter-toggle');
                const menu = dropdown.querySelector('.filter-menu');

                if (!toggle || !menu) {
                    return;
                }

                if (toggle.contains(event.target)) {
                    menu.classList.toggle('hidden');
                    const isExpanded = !menu.classList.contains('hidden');
                    toggle.setAttribute('aria-expanded', String(isExpanded));
                    return;
                }

                if (!dropdown.contains(event.target)) {
                    menu.classList.add('hidden');
                    toggle.setAttribute('aria-expanded', 'false');
                }
            });
        });
    </script>
</body>

</html>
