<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Acadelibrary</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        .book-slide {
            width: 140px;
        }

        @media (min-width: 768px) {
            .book-slide {
                width: 180px;
            }
        }

        @media (min-width: 1024px) {
            .book-slide {
                width: 235px;
            }
        }

        [x-cloak] {
            display: none !important;
        }
    </style>
</head>

<body class="bg-white antialiased min-h-screen flex flex-col relative selection:bg-black selection:text-white">

    <a href="/"
        class="absolute left-1/2 -translate-x-1/2 top-0 z-[55] bg-white rounded-b-[40px] flex justify-center items-start py-[30px] px-[20px] pointer-events-auto transition-transform active:scale-95">
        <img src="{{ asset('images/logos/acadelibrarylogo.webp') }}" class="h-[130px] w-auto" alt="Primary Logo">
    </a>

    <div class="absolute inset-0 pointer-events-none z-[60]">
        <div class="sticky top-[18px] flex justify-center w-full mt-[175px]">
            <a href="/"
                class="bg-white tracking-widest flex items-center justify-center h-[48px] rounded-full pointer-events-auto transition-transform active:scale-95">
                <img src="{{ asset('images/logos/acadelibrarylogotext.webp') }}" class="h-[40px] w-auto"
                    alt="Wordmark Acadelibrary">
            </a>
        </div>
    </div>

    <header class="sticky top-0 bg-white z-[50] w-full h-[84px] border-b border-[#535353] flex items-center">
        <div class="max-w-[1550px] w-full mx-auto px-6 md:px-12 flex items-center justify-between">
            <nav class="hidden md:flex gap-8 text-[20px] font-medium text-gray-800 w-1/3 justify-end">
                <a href="#" class="hover:text-black transition-colors">Collection</a>
                <a href="#" class="hover:text-black transition-colors">Archives</a>
                <a href="#" class="hover:text-black transition-colors">Information</a>
                <a href="#" class="hover:text-black transition-colors">About</a>
            </nav>
            <div class="hidden md:flex items-center gap-8 w-1/3 justify-start">
                <div class="relative group">
                    <img src="{{ asset('images/icons/searchicon.webp') }}" alt="Search Icon"
                        class="h-[20px] w-auto absolute left-3 top-1/2 -translate-y-1/2 pointer-events-none opacity-70 group-focus-within:opacity-100 transition-opacity">
                    <input type="text" placeholder="Search.."
                        class="pl-10 pr-4 py-1.5 border border-black rounded-[5px] text-[16px] focus:outline-none focus:ring-1 focus:ring-black w-[200px] transition-all bg-transparent">
                </div>
                <div class="flex items-center gap-8">
                    <a href="/login"
                        class="text-[20px] font-medium text-gray-800 hover:text-black transition-colors">Register</a>
                    <a href="/register"
                        class="bg-black text-white text-[20px] font-medium px-6 py-1.5 rounded-[5px] hover:bg-gray-800 transition-colors">Login</a>
                </div>
            </div>
            <button class="md:hidden text-black">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                </svg>
            </button>
        </div>
    </header>

    <main class="flex-grow flex flex-col relative z-20 pt-[220px]">

        <div class="bg-white pb-[40px] px-6 relative z-10 text-center">
            <h1 class="font-serif text-[48px] md:text-[64px] text-black leading-[1.1] mb-2">
                Welcome to Acadelibrary
            </h1>
            <p class="font-sans text-[24px] text-gray-600 w-full mx-auto leading-relaxed">
                A dedicated archive of Indonesian creative heritage and global art movements.
            </p>
        </div>

        <div class="relative w-full flex-grow flex flex-col justify-end">
            <div class="absolute bottom-0 w-full h-[362px] bg-black z-0"></div>
            <div class="relative z-10 w-full max-w-[1600px] mx-auto px-6 lg:px-12 pb-20">
                <div x-data="{ playing: true }"
                    class="relative w-full aspect-video md:aspect-[21/8] rounded-[35px] overflow-hidden bg-gray-900 shadow-2xl group">
                    <video x-ref="video" autoplay muted loop class="w-full h-full object-cover object-center">
                        <source src="{{ asset('videos/video.mp4') }}" type="video/mp4">
                    </video>
                    <div class="absolute inset-0 bg-gradient-to-t from-black/40 to-transparent"></div>
                    <div class="absolute bottom-10 right-12">
                        <button @click=" playing = !playing;playing ? $refs.video.play() : $refs.video.pause();"
                            class="rounded-full hover:scale-110 transition-all duration-300" aria-label="Toggle Video">

                            <img x-cloak x-show="!playing" src="{{ asset('images/icons/playbutton.webp') }}"
                                class="h-[30px] w-auto" alt="Play Icon">

                            <img x-cloak x-show="playing" src="{{ asset('images/icons/pausebutton.webp') }}"
                                class="h-[30px] w-auto" alt="Pause Icon">
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <section class="bg-white w-full pb-28 pt-24 relative z-20">
            <div class="max-w-[1600px] mx-auto px-6 lg:px-12">
                <div class="text-center pb-[40px]">
                    <h2 class="font-serif text-[48px] md:text-[64px] text-black leading-tight mb-2">
                        Our Services
                    </h2>
                    <p class="font-sans text-[24px] text-gray-600 font-light">
                        Access a world of knowledge through our integrated digital library services.
                    </p>
                </div>
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                    <a href="#"
                        class="group bg-[#EBEBEB] aspect-square flex flex-col items-center p-6 border border-[#D6D6D6] hover:border-[#B0B0B0] hover:bg-[#E4E4E4] transition-colors duration-300">
                        <div class="flex-grow w-full flex items-center justify-center mb-4">
                            <img src="{{ asset('images/services/searching.webp') }}" alt="Search"
                                class="w-[80%] max-h-[80%] object-contain">
                        </div>
                        <span class="font-sans text-[20px] text-[#404040] mb-2 tracking-wide">Search our
                            catalogue</span>
                    </a>
                    <a href="#"
                        class="group bg-[#EBEBEB] aspect-square flex flex-col items-center p-6 border border-[#D6D6D6] hover:border-[#B0B0B0] hover:bg-[#E4E4E4] transition-colors duration-300">
                        <div class="flex-grow w-full flex items-center justify-center mb-4">
                            <img src="{{ asset('images/services/discovering.webp') }}" alt="Discover"
                                class="w-[80%] max-h-[80%] object-contain">
                        </div>
                        <span class="font-sans text-[20px] text-[#404040] mb-2 tracking-wide">Discover our
                            collection</span>
                    </a>
                    <a href="#"
                        class="group bg-[#EBEBEB] aspect-square flex flex-col items-center p-6 border border-[#D6D6D6] hover:border-[#B0B0B0] hover:bg-[#E4E4E4] transition-colors duration-300">
                        <div class="flex-grow w-full flex items-center justify-center mb-4">
                            <img src="{{ asset('images/services/visiting.webp') }}" alt="Visit"
                                class="w-[80%] max-h-[80%] object-contain">
                        </div>
                        <span class="font-sans text-[20px] text-[#404040] mb-2 tracking-wide">Visit the library</span>
                    </a>
                    <a href="#"
                        class="group bg-[#EBEBEB] aspect-square flex flex-col items-center p-6 border border-[#D6D6D6] hover:border-[#B0B0B0] hover:bg-[#E4E4E4] transition-colors duration-300">
                        <div class="flex-grow w-full flex items-center justify-center mb-4">
                            <img src="{{ asset('images/services/borrowing.webp') }}" alt="Borrow"
                                class="w-[80%] max-h-[80%] object-contain">
                        </div>
                        <span class="font-sans text-[20px] text-[#404040] mb-2 tracking-wide">Borrow online</span>
                    </a>
                </div>
            </div>
        </section>

        <section class="bg-black w-full pt-24 pb-24 relative z-20 overflow-hidden">
            <div class="max-w-[1600px] mx-auto px-6 lg:px-12">
                <div class="text-center mb-16">
                    <h2 class="font-serif text-[44px] md:text-[56px] text-white leading-tight">
                        Featured Collection
                    </h2>
                </div>
            </div>

            <div x-data="marquee" @mouseenter="targetSpeedMultiplier = 0.15"
                @mouseleave="targetSpeedMultiplier = 1"
                class="marquee-global-wrapper flex flex-col gap-4 w-full cursor-pointer">

                <div class="marquee-track move-right w-full">
                    <div class="marquee-wrapper flex w-max">
                        <div class="marquee-content flex gap-4 pr-4 shrink-0">
                            <a href="#" class="book-slide group block bg-[#1A1A1A] shrink-0">
                                <img src="{{ asset('images/books/batik.webp') }}" alt="Batik" loading="lazy"
                                    decoding="async" fetchpriority="low"
                                    class="w-full aspect-[3/4] object-cover transition-[filter] duration-300 group-hover:brightness-125">
                            </a>
                            <a href="#" class="book-slide group block bg-[#1A1A1A] shrink-0">
                                <img src="{{ asset('images/books/katie.webp') }}" alt="Katie" loading="lazy"
                                    decoding="async" fetchpriority="low"
                                    class="w-full aspect-[3/4] object-cover transition-[filter] duration-300 group-hover:brightness-125">
                            </a>
                            <a href="#" class="book-slide group block bg-[#1A1A1A] shrink-0">
                                <img src="{{ asset('images/books/monet.webp') }}" alt="Monet" loading="lazy"
                                    decoding="async" fetchpriority="low"
                                    class="w-full aspect-[3/4] object-cover transition-[filter] duration-300 group-hover:brightness-125">
                            </a>
                            <a href="#" class="book-slide group block bg-[#1A1A1A] shrink-0">
                                <img src="{{ asset('images/books/vincent.webp') }}" alt="Vincent" loading="lazy"
                                    decoding="async" fetchpriority="low"
                                    class="w-full aspect-[3/4] object-cover transition-[filter] duration-300 group-hover:brightness-125">
                            </a>
                            <a href="#" class="book-slide group block bg-[#1A1A1A] shrink-0">
                                <img src="{{ asset('images/books/raden.webp') }}" alt="Raden" loading="lazy"
                                    decoding="async" fetchpriority="low"
                                    class="w-full aspect-[3/4] object-cover transition-[filter] duration-300 group-hover:brightness-125">
                            </a>
                            <a href="#" class="book-slide group block bg-[#1A1A1A] shrink-0">
                                <img src="{{ asset('images/books/interaction.webp') }}" alt="Interaction"
                                    loading="lazy" decoding="async" fetchpriority="low"
                                    class="w-full aspect-[3/4] object-cover transition-[filter] duration-300 group-hover:brightness-125">
                            </a>
                            <a href="#" class="book-slide group block bg-[#1A1A1A] shrink-0">
                                <img src="{{ asset('images/books/art.webp') }}" alt="Art" loading="lazy"
                                    decoding="async" fetchpriority="low"
                                    class="w-full aspect-[3/4] object-cover transition-[filter] duration-300 group-hover:brightness-125">
                            </a>
                            <a href="#" class="book-slide group block bg-[#1A1A1A] shrink-0">
                                <img src="{{ asset('images/books/sejarah.webp') }}" alt="Sejarah" loading="lazy"
                                    decoding="async" fetchpriority="low"
                                    class="w-full aspect-[3/4] object-cover transition-[filter] duration-300 group-hover:brightness-125">
                            </a>
                            <a href="#" class="book-slide group block bg-[#1A1A1A] shrink-0">
                                <img src="{{ asset('images/books/pelukis.webp') }}" alt="Pelukis" loading="lazy"
                                    decoding="async" fetchpriority="low"
                                    class="w-full aspect-[3/4] object-cover transition-[filter] duration-300 group-hover:brightness-125">
                            </a>
                            <a href="#" class="book-slide group block bg-[#1A1A1A] shrink-0">
                                <img src="{{ asset('images/books/children.webp') }}" alt="Children" loading="lazy"
                                    decoding="async" fetchpriority="low"
                                    class="w-full aspect-[3/4] object-cover transition-[filter] duration-300 group-hover:brightness-125">
                            </a>
                            <a href="#" class="book-slide group block bg-[#1A1A1A] shrink-0">
                                <img src="{{ asset('images/books/desain.webp') }}" alt="Desain" loading="lazy"
                                    decoding="async" fetchpriority="low"
                                    class="w-full aspect-[3/4] object-cover transition-[filter] duration-300 group-hover:brightness-125">
                            </a>
                            <a href="#" class="book-slide group block bg-[#1A1A1A] shrink-0">
                                <img src="{{ asset('images/books/story.webp') }}" alt="Story" loading="lazy"
                                    decoding="async" fetchpriority="low"
                                    class="w-full aspect-[3/4] object-cover transition-[filter] duration-300 group-hover:brightness-125">
                            </a>
                            <a href="#" class="book-slide group block bg-[#1A1A1A] shrink-0">
                                <img src="{{ asset('images/books/nouveau.webp') }}" alt="Nouveau" loading="lazy"
                                    decoding="async" fetchpriority="low"
                                    class="w-full aspect-[3/4] object-cover transition-[filter] duration-300 group-hover:brightness-125">
                            </a>
                            <a href="#" class="book-slide group block bg-[#1A1A1A] shrink-0">
                                <img src="{{ asset('images/books/explained.webp') }}" alt="Explained" loading="lazy"
                                    decoding="async" fetchpriority="low"
                                    class="w-full aspect-[3/4] object-cover transition-[filter] duration-300 group-hover:brightness-125">
                            </a>
                            <a href="#" class="book-slide group block bg-[#1A1A1A] shrink-0">
                                <img src="{{ asset('images/books/cats.webp') }}" alt="Cats" loading="lazy"
                                    decoding="async" fetchpriority="low"
                                    class="w-full aspect-[3/4] object-cover transition-[filter] duration-300 group-hover:brightness-125">
                            </a>
                            <a href="#" class="book-slide group block bg-[#1A1A1A] shrink-0">
                                <img src="{{ asset('images/books/graphic.webp') }}" alt="Graphic" loading="lazy"
                                    decoding="async" fetchpriority="low"
                                    class="w-full aspect-[3/4] object-cover transition-[filter] duration-300 group-hover:brightness-125">
                            </a>
                        </div>
                    </div>
                </div>

                <div class="marquee-track move-left w-full">
                    <div class="marquee-wrapper flex w-max">
                        <div class="marquee-content flex gap-4 pr-4 shrink-0">
                            <a href="#" class="book-slide group block bg-[#1A1A1A] shrink-0">
                                <img src="{{ asset('images/books/graphic.webp') }}" alt="Graphic Design"
                                    loading="lazy" decoding="async" fetchpriority="low"
                                    class="w-full aspect-[3/4] object-cover transition-[filter] duration-300 group-hover:brightness-125">
                            </a>
                            <a href="#" class="book-slide group block bg-[#1A1A1A] shrink-0">
                                <img src="{{ asset('images/books/cats.webp') }}" alt="Cats" loading="lazy"
                                    decoding="async" fetchpriority="low"
                                    class="w-full aspect-[3/4] object-cover transition-[filter] duration-300 group-hover:brightness-125">
                            </a>
                            <a href="#" class="book-slide group block bg-[#1A1A1A] shrink-0">
                                <img src="{{ asset('images/books/explained.webp') }}" alt="Explained" loading="lazy"
                                    decoding="async" fetchpriority="low"
                                    class="w-full aspect-[3/4] object-cover transition-[filter] duration-300 group-hover:brightness-125">
                            </a>
                            <a href="#" class="book-slide group block bg-[#1A1A1A] shrink-0">
                                <img src="{{ asset('images/books/nouveau.webp') }}" alt="Nouveau" loading="lazy"
                                    decoding="async" fetchpriority="low"
                                    class="w-full aspect-[3/4] object-cover transition-[filter] duration-300 group-hover:brightness-125">
                            </a>
                            <a href="#" class="book-slide group block bg-[#1A1A1A] shrink-0">
                                <img src="{{ asset('images/books/story.webp') }}" alt="Story" loading="lazy"
                                    decoding="async" fetchpriority="low"
                                    class="w-full aspect-[3/4] object-cover transition-[filter] duration-300 group-hover:brightness-125">
                            </a>
                            <a href="#" class="book-slide group block bg-[#1A1A1A] shrink-0">
                                <img src="{{ asset('images/books/desain.webp') }}" alt="Desain" loading="lazy"
                                    decoding="async" fetchpriority="low"
                                    class="w-full aspect-[3/4] object-cover transition-[filter] duration-300 group-hover:brightness-125">
                            </a>
                            <a href="#" class="book-slide group block bg-[#1A1A1A] shrink-0">
                                <img src="{{ asset('images/books/children.webp') }}" alt="Children" loading="lazy"
                                    decoding="async" fetchpriority="low"
                                    class="w-full aspect-[3/4] object-cover transition-[filter] duration-300 group-hover:brightness-125">
                            </a>
                            <a href="#" class="book-slide group block bg-[#1A1A1A] shrink-0">
                                <img src="{{ asset('images/books/pelukis.webp') }}" alt="Pelukis" loading="lazy"
                                    decoding="async" fetchpriority="low"
                                    class="w-full aspect-[3/4] object-cover transition-[filter] duration-300 group-hover:brightness-125">
                            </a>
                            <a href="#" class="book-slide group block bg-[#1A1A1A] shrink-0">
                                <img src="{{ asset('images/books/sejarah.webp') }}" alt="Sejarah" loading="lazy"
                                    decoding="async" fetchpriority="low"
                                    class="w-full aspect-[3/4] object-cover transition-[filter] duration-300 group-hover:brightness-125">
                            </a>
                            <a href="#" class="book-slide group block bg-[#1A1A1A] shrink-0">
                                <img src="{{ asset('images/books/art.webp') }}" alt="Art" loading="lazy"
                                    decoding="async" fetchpriority="low"
                                    class="w-full aspect-[3/4] object-cover transition-[filter] duration-300 group-hover:brightness-125">
                            </a>
                            <a href="#" class="book-slide group block bg-[#1A1A1A] shrink-0">
                                <img src="{{ asset('images/books/interaction.webp') }}" alt="Interaction"
                                    loading="lazy" decoding="async" fetchpriority="low"
                                    class="w-full aspect-[3/4] object-cover transition-[filter] duration-300 group-hover:brightness-125">
                            </a>
                            <a href="#" class="book-slide group block bg-[#1A1A1A] shrink-0">
                                <img src="{{ asset('images/books/raden.webp') }}" alt="Raden Saleh" loading="lazy"
                                    decoding="async" fetchpriority="low"
                                    class="w-full aspect-[3/4] object-cover transition-[filter] duration-300 group-hover:brightness-125">
                            </a>
                            <a href="#"
                                class="book-slide group block overflow-hidden bg-[#1A1A1A] shrink-0 w-[140px] md:w-[180px] lg:w-[235px]">
                                <img src="{{ asset('images/books/vincent.webp') }}" alt="Vincent" loading="lazy"
                                    decoding="async" fetchpriority="low"
                                    class="w-full aspect-[3/4] object-cover transition-[filter] duration-300 group-hover:brightness-125">
                            </a>
                            <a href="#"
                                class="book-slide group block overflow-hidden bg-[#1A1A1A] shrink-0 w-[140px] md:w-[180px] lg:w-[235px]">
                                <img src="{{ asset('images/books/monet.webp') }}" alt="Monet" loading="lazy"
                                    decoding="async" fetchpriority="low"
                                    class="w-full aspect-[3/4] object-cover transition-[filter] duration-300 group-hover:brightness-125">
                            </a>
                            <a href="#"
                                class="book-slide group block overflow-hidden bg-[#1A1A1A] shrink-0 w-[140px] md:w-[180px] lg:w-[235px]">
                                <img src="{{ asset('images/books/katie.webp') }}" alt="Katie" loading="lazy"
                                    decoding="async" fetchpriority="low"
                                    class="w-full aspect-[3/4] object-cover transition-[filter] duration-300 group-hover:brightness-125">
                            </a>
                            <a href="#" class="group block overflow-hidden bg-[#1A1A1A] book-slide shrink-0">
                                <img src="{{ asset('images/books/batik.webp') }}" alt="Batik" loading="lazy"
                                    decoding="async" fetchpriority="low"
                                    class="w-full aspect-[3/4] object-cover transition-[filter] duration-300 group-hover:brightness-125">
                            </a>
                        </div>
                    </div>
                </div>

            </div>

            <div class="max-w-[1600px] mx-auto px-6 lg:px-12">
                <div class="text-center mt-16 mb-8">
                    <a href="#" class="group inline-flex items-center gap-2 font-sans text-white text-[20px]">
                        See more collection <img src="{{ asset('images/icons/rightarrow.webp') }}" alt=""
                            class="w-auto h-6 transition-transform duration-300 ease-out group-hover:translate-x-2">
                    </a>
                </div>
            </div>
        </section>

        <section class="bg-white w-full pb-32 md:pb-[500px] relative z-20">
            <div class="max-w-[1800px] mx-auto px-6 lg:px-12">
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-14 items-start">
                    <div class="relative w-full h-[160px]">
                        <a href="#"
                            class="absolute top-0 left-0 w-full bg-black text-white flex flex-col justify-start overflow-hidden transition-[max-height] duration-700 ease-[cubic-bezier(0.42,1.25,0.42,1)] max-h-[160px] hover:max-h-[500px] z-10 hover:z-50 group">
                            <div class="w-full h-[160px] flex items-center justify-center shrink-0 px-4">
                                <h3 class="font-serif italic text-[26px] md:text-[32px] leading-snug text-center">
                                    Branding & Visual<br>Identity
                                </h3>
                            </div>
                            <div
                                class="w-full px-9 pb-10 opacity-0 group-hover:opacity-100 transition-opacity duration-500 delay-100">
                                <p class="font-sans text-[24px] text-gray-300 leading-snug text-justify">
                                    Deep exploration into the anatomy and history of letterforms shaping the face of
                                    modern visuals across cultures.
                                </p>
                                <div class="mt-8 text-left">
                                    <span
                                        class="group/view inline-flex items-center gap-2 font-sans text-white text-[20px]">
                                        View Collection <img src="{{ asset('images/icons/rightarrow.webp') }}"
                                            alt=""
                                            class="w-auto h-6 transition-transform duration-300 ease-out group-hover/view:translate-x-2">
                                    </span>
                                </div>
                            </div>
                        </a>
                    </div>

                    <div class="relative w-full h-[160px]">
                        <a href="#"
                            class="absolute top-0 left-0 w-full bg-black text-white flex flex-col justify-start overflow-hidden transition-[max-height] duration-700 ease-[cubic-bezier(0.42,1.25,0.42,1)] max-h-[160px] hover:max-h-[500px] z-10 hover:z-50 group">
                            <div class="w-full h-[160px] flex items-center justify-center shrink-0 px-4">
                                <h3 class="font-serif italic text-[26px] md:text-[32px] leading-snug text-center">
                                    Typography &<br>Typeface
                                </h3>
                            </div>
                            <div
                                class="w-full px-9 pb-10 opacity-0 group-hover:opacity-100 transition-opacity duration-500 delay-100">
                                <p class="font-sans text-[24px] text-gray-300 leading-snug text-justify">
                                    Strategic convergence of symbols and colors building compelling narratives and
                                    creating timeless identities for global perspective.
                                </p>
                                <div class="mt-8 text-left">
                                    <span
                                        class="group/view inline-flex items-center gap-2 font-sans text-white text-[20px]">
                                        View Collection <img src="{{ asset('images/icons/rightarrow.webp') }}"
                                            alt=""
                                            class="w-auto h-6 transition-transform duration-300 ease-out group-hover/view:translate-x-2">
                                    </span>
                                </div>
                            </div>
                        </a>
                    </div>

                    <div class="relative w-full h-[160px]">
                        <a href="#"
                            class="absolute top-0 left-0 w-full bg-black text-white flex flex-col justify-start overflow-hidden transition-[max-height] duration-700 ease-[cubic-bezier(0.42,1.25,0.42,1)] max-h-[160px] hover:max-h-[500px] z-10 hover:z-50 group">
                            <div class="w-full h-[160px] flex items-center justify-center shrink-0 px-4">
                                <h3 class="font-serif italic text-[26px] md:text-[32px] leading-snug text-center">
                                    Visual Theory<br>& Aesthetics
                                </h3>
                            </div>
                            <div
                                class="w-full px-9 pb-10 opacity-0 group-hover:opacity-100 transition-opacity duration-500 delay-100">
                                <p class="font-sans text-[24px] text-gray-300 leading-snug text-justify">
                                    An in-depth study of the fundamental principles of beauty, composition, and form
                                    within the world of fine arts.
                                </p>
                                <div class="mt-8 text-left">
                                    <span
                                        class="group/view inline-flex items-center gap-2 font-sans text-white text-[20px]">
                                        View Collection <img src="{{ asset('images/icons/rightarrow.webp') }}"
                                            alt=""
                                            class="w-auto h-6 transition-transform duration-300 ease-out group-hover/view:translate-x-2">
                                    </span>
                                </div>
                            </div>
                        </a>
                    </div>

                    <div class="relative w-full h-[160px]">
                        <a href="#"
                            class="absolute top-0 left-0 w-full bg-black text-white flex flex-col justify-start overflow-hidden transition-[max-height] duration-700 ease-[cubic-bezier(0.42,1.25,0.42,1)] max-h-[160px] hover:max-h-[500px] z-10 hover:z-50 group">
                            <div class="w-full h-[160px] flex items-center justify-center shrink-0 px-4">
                                <h3 class="font-serif italic text-[26px] md:text-[32px] leading-snug text-center">
                                    Junior Artist’s<br>Gallery
                                </h3>
                            </div>
                            <div
                                class="w-full px-9 pb-10 opacity-0 group-hover:opacity-100 transition-opacity duration-500 delay-100">
                                <p class="font-sans text-[24px] text-gray-300 leading-snug text-justify">
                                    An inspiring gateway for young creators to discover the world of art through
                                    educational and creative literature from an early age.
                                </p>
                                <div class="mt-8 text-left">
                                    <span
                                        class="group/view inline-flex items-center gap-2 font-sans text-white text-[20px]">
                                        View Collection <img src="{{ asset('images/icons/rightarrow.webp') }}"
                                            alt=""
                                            class="w-auto h-6 transition-transform duration-300 ease-out group-hover/view:translate-x-2">
                                    </span>
                                </div>
                            </div>
                        </a>
                    </div>

                </div>
            </div>
        </section>

        <section class="bg-white w-full relative z-20">
            <div class="max-w-[1600px] mx-auto px-6 lg:px-12">
                <div class="text-center mb-12">
                    <h2 class="font-serif text-[48px] md:text-[56px] text-black leading-tight mb-3">
                        Borrowing Guide
                    </h2>
                    <p class="font-sans text-[20px] md:text-[22px] text-[#4A4A4A] font-light">
                        Follow these four simple steps to reserve and enjoy our curated art and design literature.
                    </p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                    <div
                        class="bg-[#E6E6E6] p-8 flex flex-col items-center shadow-[4px_4px_15px_rgba(0,0,0,0.08)] border border-[#E0E0E0] h-full">
                        <h3 class="font-serif italic text-[32px] text-black mb-1">Step 01: Discover</h3>
                        <p class="font-sans text-[22px] text-[#4A4A4A] mb-8">Find Your Inspiration</p>
                        <div class="flex-grow flex items-center justify-center w-full mb-8 min-h-[180px]">
                            <img src="{{ asset('images/guides/step1.webp') }}" alt="Step 1"
                                class="w-auto max-h-[328px] object-contain">
                        </div>
                        <p class="font-sans text-[20px] leading-snug text-[#4A4A4A] text-justify w-full">
                            Browse our curated collection of national and international art masterpieces through the
                            search bar or categories.
                        </p>
                    </div>

                    <div
                        class="bg-[#E6E6E6] p-8 flex flex-col items-center shadow-[4px_4px_15px_rgba(0,0,0,0.08)] border border-[#E0E0E0] h-full">
                        <h3 class="font-serif italic text-[32px] text-black mb-1">Step 02: Request</h3>
                        <p class="font-sans text-[22px] text-[#4A4A4A] mb-8">Reserve the Masterpiece</p>
                        <div class="flex-grow flex items-center justify-center w-full mb-8 min-h-[180px]">
                            <img src="{{ asset('images/guides/step2.webp') }}" alt="Step 2"
                                class="w-auto max-h-[328px] object-contain">
                        </div>
                        <p class="font-sans text-[20px] leading-snug text-[#4A4A4A] text-justify w-full">
                            Once you find your desired literature, click the "Borrow" button to submit your digital
                            request to our system.
                        </p>
                    </div>

                    <div
                        class="bg-[#E6E6E6] p-8 flex flex-col items-center shadow-[4px_4px_15px_rgba(0,0,0,0.08)] border border-[#E0E0E0] h-full">
                        <h3 class="font-serif italic text-[32px] text-black mb-1">Step 03: Verify</h3>
                        <p class="font-sans text-[22px] text-[#4A4A4A] mb-8">Authentication Process</p>
                        <div class="flex-grow flex items-center justify-center w-full mb-8 min-h-[180px]">
                            <img src="{{ asset('images/guides/step3.webp') }}" alt="Step 3"
                                class="w-auto max-h-[328px] object-contain">
                        </div>
                        <p class="font-sans text-[20px] leading-snug text-[#4A4A4A] text-justify w-full">
                            Our librarian will review your request, confirming book availability and verifying your
                            membership status.
                        </p>
                    </div>

                    <div
                        class="bg-[#E6E6E6] p-8 flex flex-col items-center shadow-[4px_4px_15px_rgba(0,0,0,0.08)] border border-[#E0E0E0] h-full">
                        <h3 class="font-serif italic text-[32px] text-black mb-1">Step 04: Read</h3>
                        <p class="font-sans text-[22px] text-[#4A4A4A] mb-8">Authentication Process</p>
                        <div class="flex-grow flex items-center justify-center w-full mb-8 min-h-[180px]">
                            <img src="{{ asset('images/guides/step4.webp') }}" alt="Step 4"
                                class="w-auto max-h-[328px] object-contain">
                        </div>
                        <p class="font-sans text-[20px] leading-snug text-[#4A4A4A] text-justify w-full">
                            After approval, you can access the digital version instantly or pick up the physical copy at
                            our library gallery.
                        </p>
                    </div>

                </div>
            </div>
        </section>

        <section class="bg-white w-full py-32 md:py-[1200px] relative z-20">
            <div class="max-w-[1800px] mx-auto flex justify-center">
                <div x-data="scrollReveal" x-ref="container"
                    class="font-serif text-[36px] md:text-[56px] lg:text-[130px] leading-[1.1] text-center uppercase text-black flex flex-wrap justify-center pointer-events-none">
                    <template x-for="(line, index) in lines" :key="index">
                        <div>
                            <span x-text="line" class="block transition-opacity duration-150 will-change-opacity"
                                style="opacity: 0.15;">
                            </span>
                        </div>
                    </template>
                    <span>
                        <span x-text="word"
                            class="inline-block transition-opacity duration-700 will-change-[opacity,transform]"
                            style="opacity: 0.15;"></span>
                        <span x-show="index !== words.length - 1"
                            class="inline-block w-[12px] md:w-[16px] lg:w-[20px]">&nbsp;</span>
                    </span>
                    </template>
                </div>
            </div>
        </section>
    </main>

    <footer class="bg-black relative pt-[170px] pb-12 w-full z-30">
        <div
            class="absolute top-0 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[90%] max-w-[1400px] bg-white border border-black shadow-2xl p-10 md:p-16 z-40">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-10 lg:gap-10 mb-12">
                <div class="flex flex-col justify-center">
                    <img src="{{ asset('images/logos/acadelibrarylogotext.webp') }}"
                        class="h-[50px] md:h-[100px] w-max object-contain object-left" alt="Acadelibrary Wordmark">
                </div>
                <div class="flex flex-col justify-center">
                    <p class="font-serif italic text-[24px] md:text-[34px] text-black leading-tight">
                        "A sanctuary for the eyes, a home for the soul, and a gallery for the mind."
                    </p>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 lg:gap-10">
                <div class="lg:col-span-4 flex flex-col justify-center">
                    <p
                        class="font-sans italic text-[16px] md:text-[19px] text-black leading-snug text-justify pr-[13px]">
                        Receive monthly insights on art history, rare manuscript acquisitions, and exclusive invitations
                        to our private gallery showcases.
                    </p>
                </div>

                <div class="lg:col-span-8 flex flex-col justify-center">
                    <form class="flex w-full border border-black h-[56px] md:h-[64px]">
                        <input type="email" placeholder="Enter Your Email"
                            class="flex-grow px-5 py-2 font-serif text-[16px] md:text-[20px] text-black outline-none bg-transparent placeholder-gray-500 h-full">
                        <button type="submit"
                            class="bg-black text-white font-serif text-[16px] md:text-[22px] px-6 md:px-10 h-full hover:bg-gray-800 transition-colors whitespace-nowrap">
                            Subscribe Now
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <div class="max-w-[1600px] mx-auto px-6 lg:px-12 pt-16 md:pt-20">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-12 gap-12 lg:gap-8 text-white mb-20">
                <div class="lg:col-span-4 flex flex-col pr-11">
                    <h4 class="font-serif text-[40px] mb-6">About Acadelibrary</h4>
                    <p class="font-sans text-[22px] text-gray-300 leading-relaxed text-justify">
                        Acadelibrary serves as a sanctuary for the preservation of creative heritage and global art
                        movements. We bridge the gap between historical masterpieces and the future of visual theory,
                        offering a curated path for every seeker of aesthetic wisdom.
                    </p>
                </div>
                <div class="lg:col-span-3 flex flex-col pl-8">
                    <h4 class="font-serif text-[40px] mb-6">Quick Link</h4>
                    <div class="flex flex-col gap-3">
                        <a href="#"
                            class="font-sans text-[22px] text-gray-300 hover:text-white transition-colors">Typography &
                            Typeface</a>
                        <a href="#"
                            class="font-sans text-[22px] text-gray-300 hover:text-white transition-colors">Branding &
                            Visual Identity</a>
                        <a href="#"
                            class="font-sans text-[22px] text-gray-300 hover:text-white transition-colors">Visual
                            Theory & Aesthetics</a>
                        <a href="#"
                            class="font-sans text-[22px] text-gray-300 hover:text-white transition-colors">Junior
                            Artist's Gallery</a>
                        <a href="#"
                            class="font-sans text-[22px] text-gray-300 hover:text-white transition-colors">Featured
                            Collection</a>
                    </div>
                </div>
                <div class="lg:col-span-3 flex flex-col pl-10">
                    <h4 class="font-serif text-[40px] mb-6">Information</h4>
                    <div class="flex flex-col gap-3">
                        <a href="#"
                            class="font-sans text-[22px] text-gray-300 hover:text-white transition-colors">Borrowing
                            Rules</a>
                        <a href="#"
                            class="font-sans text-[22px] text-gray-300 hover:text-white transition-colors">FAQs</a>
                        <a href="#"
                            class="font-sans text-[22px] text-gray-300 hover:text-white transition-colors">Privacy
                            Policy</a>
                        <a href="#"
                            class="font-sans text-[22px] text-gray-300 hover:text-white transition-colors">Term &
                            Conditions</a>
                    </div>
                </div>
                <div class="lg:col-span-2 flex flex-col">
                    <h4 class="font-serif text-[40px] mb-6">Services</h4>
                    <div class="flex flex-col gap-3">
                        <a href="#"
                            class="font-sans text-[22px] text-gray-300 hover:text-white transition-colors">Borrow
                            online</a>
                        <a href="#"
                            class="font-sans text-[22px] text-gray-300 hover:text-white transition-colors">Curated
                            Collections</a>
                        <a href="#"
                            class="font-sans text-[22px] text-gray-300 hover:text-white transition-colors">Digital
                            Archive</a>
                        <a href="#"
                            class="font-sans text-[22px] text-gray-300 hover:text-white transition-colors">Visiting The
                            Library</a>
                    </div>
                </div>
            </div>

        </div>
        <div class="border-t border-gray-100 pt-8 flex flex-col md:flex-row items-center justify-between gap-6">
            <div class="px-24 flex justify-between items-center w-full">
                <p class="font-sans text-[16px] text-gray-400 text-center md:text-left">
                    <span class="text-white font-medium">© 2026 Acadelibrary. All Rights Reserved.</span> Crafted with
                    passion in Indonesia for the global art community.
                </p>
                <div class="flex gap-6 items-center">
                    <a href="#" class="transition-opacity duration-300 hover:opacity-60">
                        <img src="{{ asset('images/icons/facebook.webp') }}" alt="Facebook" class="w-auto h-5">
                    </a>

                    <a href="#" class="transition-opacity duration-300 hover:opacity-60">
                        <img src="{{ asset('images/icons/instagram.webp') }}" alt="Instagram" class="w-auto h-5">
                    </a>

                    <a href="#" class="transition-opacity duration-300 hover:opacity-60">
                        <img src="{{ asset('images/icons/youtube.webp') }}" alt="YouTube" class="w-auto h-5">
                    </a>

                    <a href="#" class="transition-opacity duration-300 hover:opacity-60">
                        <img src="{{ asset('images/icons/twitter.webp') }}" alt="Twitter" class="w-auto h-5">
                    </a>

                    <a href="#" class="transition-opacity duration-300 hover:opacity-60">
                        <img src="{{ asset('images/icons/pinterest.webp') }}" alt="Pinterest" class="w-auto h-5">
                    </a>
                </div>
            </div>
        </div>
    </footer>

    <script>
        document.addEventListener('alpine:init', () => {

            Alpine.data('marquee', () => ({
                baseSpeed: 1.2,
                targetSpeedMultiplier: 1,
                currentSpeedMultiplier: 1,
                tracks: [],

                init() {
                    const trackElements = this.$el.querySelectorAll('.marquee-track');

                    this.tracks = Array.from(trackElements).map(trackEl => {
                        const wrapper = trackEl.querySelector('.marquee-wrapper');
                        const content = trackEl.querySelector('.marquee-content');

                        const clone = content.cloneNode(true);
                        wrapper.appendChild(clone);

                        return {
                            el: wrapper,
                            direction: trackEl.classList.contains('move-right') ? 1 : -1,
                            x: 0,
                            width: 0,
                            contentEl: content
                        };
                    });

                    window.addEventListener('load', () => {
                        this.calculateWidths();
                        this.animate();
                    });

                    window.addEventListener('resize', () => this.calculateWidths());
                },

                calculateWidths() {
                    this.tracks.forEach(track => {
                        track.width = track.contentEl.getBoundingClientRect().width;

                        if (track.direction === 1 && track.x === 0) {
                            track.x = -track.width;
                        }
                    });
                },

                animate() {
                    this.currentSpeedMultiplier += (this.targetSpeedMultiplier - this
                        .currentSpeedMultiplier) * 0.05;

                    this.tracks.forEach(track => {
                        if (track.width === 0) return;

                        track.x += (this.baseSpeed * this.currentSpeedMultiplier) * track
                            .direction;

                        if (track.direction === -1 && track.x <= -track.width) {
                            track.x += track.width;
                        } else if (track.direction === 1 && track.x >= 0) {
                            track.x -= track.width;
                        }

                        track.el.style.transform = `translate3d(${track.x}px, 0, 0)`;
                    });

                    requestAnimationFrame(() => this.animate());
                }
            }));

            Alpine.data('scrollReveal', () => ({
                lines: [
                    "ART IS NOT JUST",
                    "WHAT YOU SEE",
                    "IT IS A DEEPER",
                    "SENSE OF FEELING",
                    "THAT MOVES THROUGH",
                    "EVERY HUMAN MIND",
                    "CONNECTED BY THE",
                    "WAY WE CREATE",
                    "UNTIL IT FINALLY",
                    "AWAKENS YOUR SOUL"
                ],

                init() {
                    this.$nextTick(() => {
                        this.updateOpacities();

                        window.addEventListener('scroll', () => {
                            requestAnimationFrame(() => this.updateOpacities());
                        }, {
                            passive: true
                        });

                        window.addEventListener('resize', () => {
                            requestAnimationFrame(() => this.updateOpacities());
                        }, {
                            passive: true
                        });
                    });
                },

                updateOpacities() {
                    if (!this.$refs.container) return;

                    const wordElements = this.$refs.container.querySelectorAll(':scope > div > span');
                    const centerY = window.innerHeight / 2.1;
                    const maxDist = window.innerHeight / 2;

                    wordElements.forEach(span => {
                        const rect = span.getBoundingClientRect();
                        const spanCenterY = rect.top + (rect.height / 2);
                        const dist = Math.abs(centerY - spanCenterY);

                        let opacity = 1 - (dist / maxDist);
                        opacity = Math.max(0.15, Math.min(1, opacity));

                        const currentOpacity = parseFloat(span.style.opacity) || 0.15;
                        const smoothOpacity = currentOpacity + (opacity - currentOpacity) *
                            0.3;
                        span.style.opacity = smoothOpacity;

                        const scale = 0.95 + (smoothOpacity * 0.05);
                        span.style.transform = `scale(${scale})`;
                    });
                }
            }));

        });
    </script>
</body>

</html>
