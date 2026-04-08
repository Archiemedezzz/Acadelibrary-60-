<header class="h-[84px] border-b-2 border-[#c9c9c9] flex items-center justify-between px-10 shrink-0 bg-white"
    x-data="{ open: false }">

    <h1 class="font-serif text-[28px] md:text-[32px] text-black">
        <script>
            document.write(
                new Date().getHours() < 12 ? 'Good Morning' :
                new Date().getHours() < 17 ? 'Good Afternoon' : 'Good Evening'
            );
        </script>, {{ auth()->user()->name }}.
    </h1>

    <!-- Right Actions -->
    <div class="flex items-center gap-8">
        <!-- Notification -->
        <button class="relative text-gray-600 hover:text-black transition-colors">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                stroke-width="1.5">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
            </svg>
            <span class="absolute top-[2px] right-[3px] w-2 h-2 bg-red-500 rounded-full border border-white"></span>
        </button>

        <!-- Profile Dropdown -->
        <div class="relative" @click.outside="open = false">
            <button @click="open = !open"
                class="flex items-center gap-3 pl-8 border-l border-gray-300 cursor-pointer group">
                <img src="{{ auth()->user()->avatar ? asset('storage/' . auth()->user()->avatar) : asset('images/avatar-placeholder.webp') }}"
                    class="w-[42px] h-[42px] rounded-full bg-gray-200 object-cover border border-gray-300"
                    alt="Avatar">
                <div class="flex flex-col">
                    <span
                        class="text-[14px] font-bold text-black leading-tight group-hover:text-gray-600 transition-colors">{{ auth()->user()->name }}</span>
                    <span class="text-[12px] text-gray-500 leading-tight mt-0.5">Librarian</span>
                </div>
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-400 ml-1 transition-transform"
                    :class="open ? 'rotate-180' : ''" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                    stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                </svg>
            </button>

            <!-- Dropdown Menu -->
            <div x-show="open" x-cloak x-transition @click.stop
                class="absolute right-0 top-full mt-2 w-48 bg-white border border-gray-200 rounded-lg shadow-lg py-1 z-50">
                <a href="{{ route('profile.edit') }}"
                    class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 transition-colors">Preferences</a>
                <form method="POST" action="{{ route('logout') }}" class="block">
                    @csrf
                    <button type="submit"
                        class="w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 transition-colors">Sign
                        Out</button>
                </form>
            </div>
        </div>
    </div>
</header>
