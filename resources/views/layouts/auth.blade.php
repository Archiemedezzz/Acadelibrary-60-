<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="antialiased min-h-screen flex items-center justify-center relative font-sans selection:bg-white selection:text-black">
    <div class="fixed inset-0 z-0">
        <img src="{{ asset('images/waterlilybackground.webp') }}" class="w-full h-full object-cover">
        <div class="absolute inset-0 bg-black/90"></div>
    </div>

    @yield('content')

</body>
</html>
