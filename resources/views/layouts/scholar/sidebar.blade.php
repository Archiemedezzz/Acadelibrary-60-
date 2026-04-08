<aside class="w-[260px] border-r-2 border-[#c9c9c9] flex flex-col shrink-0 bg-white z-20">

    <!-- Logo Area -->
    <div class="h-[84px] border-b-2 border-[#c9c9c9] flex items-center px-6 shrink-0">
        <a href="/" class="flex items-center gap-3">
            <img src="{{ asset('images/logos/acadelibrarylogotext.webp') }}" alt="Acadelibrary Logo">
        </a>
    </div>

    <!-- Navigation Links -->
    <div class="flex-1 flex flex-col py-6 gap-8">

        <!-- MAIN MENU -->
        <div class="flex flex-col gap-2">
            <span class="px-6 text-[16px] font-serif font-bold tracking-widest text-[#2f2f2f] uppercase mb-2">
                Main Menu
            </span>

            <!-- HOME -->
            <a href="{{ route('scholar.dashboard') }}"
                class="flex items-center gap-3 px-6 py-2.5 text-[16px] font-sans font-medium mx-3 rounded-[5px]
                {{ request()->routeIs('scholar.dashboard') ? 'bg-black text-white' : 'text-gray-700' }}">

                <img src="{{ asset('images/icons/home.png') }}"
                    class="w-6 h-6 {{ request()->routeIs('scholar.dashboard') ? 'invert brightness-0' : '' }}">

                Home
            </a>

            <!-- DISCOVER -->
            <a href="{{ route('scholar.discover') }}"
                class="flex items-center gap-3 px-6 py-2.5 text-[16px] font-sans font-medium mx-3 rounded-[5px]
                {{ request()->routeIs('scholar.discover') ? 'bg-black text-white' : 'text-gray-700' }}">

                <img src="{{ asset('images/icons/discover.png') }}"
                    class="w-6 h-6 {{ request()->routeIs('scholar.discover') ? 'invert brightness-0' : '' }}">

                Discover
            </a>
        </div>

        <!-- ACTIVITY -->
        <div class="flex flex-col gap-2">
            <span class="px-6 text-[16px] font-serif font-bold tracking-widest text-[#2f2f2f] uppercase mb-2">
                Activity
            </span>

            <!-- READING LOG -->
            <a href="{{ route('scholar.reading-log.index') }}"
                class="flex items-center gap-3 px-6 py-2.5 text-[16px] font-sans font-medium mx-3 rounded-[5px]
                {{ request()->routeIs('scholar.reading-log.index') ? 'bg-black text-white' : 'text-gray-700' }}">

                <img src="{{ asset('images/icons/log.png') }}"
                    class="w-6 h-6 {{ request()->routeIs('scholar.reading-log.index') ? 'invert brightness-0' : '' }}">

                Reading Log
            </a>
        </div>

        <!-- SUPPORT -->
        <div class="mt-auto flex flex-col gap-2 pt-8">
            <span class="px-6 text-[16px] font-serif font-bold tracking-widest text-[#2f2f2f] uppercase mb-2">
                Support
            </span>

            <!-- HELP -->
            <a href="{{ route('scholar.help') }}"
                class="flex items-center gap-3 px-6 py-2.5 text-[16px] font-sans font-medium mx-3 rounded-[5px]
                {{ request()->routeIs('scholar.help') ? 'bg-black text-white' : 'text-gray-700' }}">

                <img src="{{ asset('images/icons/help.png') }}"
                    class="w-6 h-6 {{ request()->routeIs('scholar.help') ? 'invert brightness-0' : '' }}">

                Help
            </a>

            <!-- FEEDBACK -->
            <a href="{{ route('scholar.feedback') }}"
                class="flex items-center gap-3 px-6 py-2.5 text-[16px] font-sans font-medium mx-3 rounded-[5px] mb-4
                {{ request()->routeIs('scholar.feedback') ? 'bg-black text-white' : 'text-gray-700' }}">

                <img src="{{ asset('images/icons/feedback.png') }}"
                    class="w-6 h-6 {{ request()->routeIs('scholar.feedback') ? 'invert brightness-0' : '' }}">

                Feedback
            </a>
        </div>

    </div>
</aside>
