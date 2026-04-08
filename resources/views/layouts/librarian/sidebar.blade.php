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
            <a href="{{ route('librarian.dashboard') }}"
                class="flex items-center gap-3 px-6 py-2.5 text-[16px] font-sans font-medium mx-3 rounded-[5px]
                {{ request()->routeIs('librarian.dashboard') ? 'bg-black text-white' : 'text-gray-700' }}">

                <img src="{{ asset('images/icons/home.png') }}"
                    class="w-6 h-6 {{ request()->routeIs('librarian.dashboard') ? 'invert brightness-0' : '' }}">

                Home
            </a>

            <!-- DISCOVER -->
            <a href="{{ route('librarian.discover') }}"
                class="flex items-center gap-3 px-6 py-2.5 text-[16px] font-sans font-medium mx-3 rounded-[5px]
                {{ request()->routeIs('librarian.discover') ? 'bg-black text-white' : 'text-gray-700' }}">

                <img src="{{ asset('images/icons/discover.png') }}"
                    class="w-6 h-6 {{ request()->routeIs('librarian.discover') ? 'invert brightness-0' : '' }}">

                Discover
            </a>
        </div>

        <!-- ACTIVITY -->
        <div class="flex flex-col gap-2">
            <span class="px-6 text-[16px] font-serif font-bold tracking-widest text-[#2f2f2f] uppercase mb-2">
                Activity
            </span>

            <a href="{{ route('librarian.reading-log.index') }}"
                class="flex items-center gap-3 px-6 py-2.5 text-[16px] font-sans font-medium mx-3 rounded-[5px]
                {{ request()->routeIs('librarian.reading-log.index') ? 'bg-black text-white' : 'text-gray-700' }}">

                <img src="{{ asset('images/icons/log.png') }}"
                    class="w-6 h-6 {{ request()->routeIs('librarian.reading-log.index') ? 'invert brightness-0' : '' }}">

                Reading Log
            </a>
        </div>

        <!-- MANAGEMENT (INI YANG BARU) -->
        <div class="flex flex-col gap-2">
            <span class="px-6 text-[16px] font-serif font-bold tracking-widest text-[#2f2f2f] uppercase mb-2">
                Management
            </span>

            <!-- Manage Books -->
            <a href="{{ route('librarian.manage-books') }}"
                class="flex items-center gap-3 px-6 py-2.5 text-[16px] font-sans font-medium mx-3 rounded-[5px]
                {{ request()->routeIs('librarian.manage-books') ? 'bg-black text-white' : 'text-gray-700' }}">

                <img src="{{ asset('images/icons/books.png') }}"
                    class="w-6 h-6 {{ request()->routeIs('librarian.manage-books') ? 'invert brightness-0' : '' }}">

                Manage Books
            </a>

            <!-- Manage Scholars -->
            <a href="{{ route('librarian.manage-scholars') }}"
                class="flex items-center gap-3 px-6 py-2.5 text-[16px] font-sans font-medium mx-3 rounded-[5px]
                {{ request()->routeIs('librarian.manage-scholars') ? 'bg-black text-white' : 'text-gray-700' }}">

                <img src="{{ asset('images/icons/users.png') }}"
                    class="w-6 h-6 {{ request()->routeIs('librarian.manage-scholars') ? 'invert brightness-0' : '' }}">

                Manage Scholars
            </a>

            <!-- Circulations -->
            <a href="{{ route('librarian.circulations') }}"
                class="flex items-center gap-3 px-6 py-2.5 text-[16px] font-sans font-medium mx-3 rounded-[5px]
                {{ request()->routeIs('librarian.circulations') ? 'bg-black text-white' : 'text-gray-700' }}">

                <img src="{{ asset('images/icons/circulations.png') }}"
                    class="w-6 h-6 {{ request()->routeIs('librarian.circulations') ? 'invert brightness-0' : '' }}">

                Circulations
            </a>

            <!-- Reports -->
            <a href="{{ route('librarian.reports') }}"
                class="flex items-center gap-3 px-6 py-2.5 text-[16px] font-sans font-medium mx-3 rounded-[5px]
                {{ request()->routeIs('librarian.reports') ? 'bg-black text-white' : 'text-gray-700' }}">

                <img src="{{ asset('images/icons/reports.png') }}"
                    class="w-6 h-6 {{ request()->routeIs('librarian.reports') ? 'invert brightness-0' : '' }}">

                Reports
            </a>
        </div>

        <!-- SUPPORT -->
        <div class="mt-auto flex flex-col gap-2 pt-8">
            <span class="px-6 text-[16px] font-serif font-bold tracking-widest text-[#2f2f2f] uppercase mb-2">
                Support
            </span>

            <a href="{{ route('librarian.help') }}"
                class="flex items-center gap-3 px-6 py-2.5 text-[16px] font-sans font-medium mx-3 rounded-[5px]
                {{ request()->routeIs('librarian.help') ? 'bg-black text-white' : 'text-gray-700' }}">

                <img src="{{ asset('images/icons/help.png') }}"
                    class="w-6 h-6 {{ request()->routeIs('librarian.help') ? 'invert brightness-0' : '' }}">

                Help
            </a>

            <a href="{{ route('librarian.feedback') }}"
                class="flex items-center gap-3 px-6 py-2.5 text-[16px] font-sans font-medium mx-3 rounded-[5px] mb-4
                {{ request()->routeIs('librarian.feedback') ? 'bg-black text-white' : 'text-gray-700' }}">

                <img src="{{ asset('images/icons/feedback.png') }}"
                    class="w-6 h-6 {{ request()->routeIs('librarian.feedback') ? 'invert brightness-0' : '' }}">

                Feedback
            </a>
        </div>

    </div>
</aside>
