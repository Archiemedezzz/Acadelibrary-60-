@extends('layouts.librarian')

@section('title', 'Reading Log - Acadelibrary')

@section('content')
<div x-data="readingLog()" class="max-w-[1600px] mx-auto w-full flex flex-col gap-6">

    <!-- MAIN TABLE CARD -->
    <div class="bg-white border border-[#D1D5DB] rounded-[10px] p-6 flex flex-col gap-6 shadow-sm">

        <!-- SEARCH & FILTERS -->
        <!-- x-data tambahan untuk handle dropdown filter -->
        <div class="flex flex-col xl:flex-row xl:items-center justify-between gap-4" x-data="{ filterOpen: false }">

            <div class="flex flex-wrap items-center gap-3 w-full">

                <!-- Search Bar & Filter Dropdown -->
                <div class="relative filter-dropdown-wrapper">
                    <img src="{{ asset('images/icons/searchicon.webp') }}"
                        class="w-5 h-5 absolute left-3 top-1/2 -translate-y-1/2">

                    <form method="GET" action="{{ route('librarian.reading-log.index') }}" id="searchForm"
                        class="contents">
                        <!-- Menyimpan parameter filter aktif agar tidak hilang saat mencari -->
                        @if (request('borrowing'))
                        <input type="hidden" name="borrowing" value="1">
                        @endif
                        @if (request('returned'))
                        <input type="hidden" name="returned" value="1">
                        @endif
                        @if (request('overdue'))
                        <input type="hidden" name="overdue" value="1">
                        @endif
                        @if (request('sort'))
                        <input type="hidden" name="sort" value="{{ request('sort') }}">
                        @endif

                        <input type="text" name="search" value="{{ request('search') }}"
                            placeholder="Search History..."
                            class="border border-[#D1D5DB] rounded-[6px] pl-9 pr-9 py-2 text-[16px] w-[220px] md:w-[280px]
                            focus:outline-none focus:ring-0 outline-none focus:border-[#000000]
                            placeholder-[#9CA3AF] bg-[#F8F9FB] transition-colors"
                            onchange="document.getElementById('searchForm').submit()">
                    </form>

                    <!-- Filter Toggle Button -->
                    <button type="button" @click="filterOpen = !filterOpen" @click.away="filterOpen = false"
                        class="filter-toggle absolute right-3 top-1/2 -translate-y-1/2 cursor-pointer outline-none">
                        <img src="{{ asset('images/icons/filter.png') }}" class="w-4 h-4">
                    </button>

                    <!-- Filter Dropdown Menu (Alpine JS) -->
                    <div x-show="filterOpen" x-transition style="display: none;"
                        class="filter-menu absolute left-0 top-full mt-2 w-[220px] rounded-[8px] bg-white border border-[#E5E7EB] shadow-[0_10px_30px_rgba(15,23,42,0.08)] py-2 z-20">

                        <!-- List opsi dengan array_merge untuk menggabungkan query param yang sudah ada -->
                        <a href="{{ route('librarian.reading-log.index', array_merge(request()->query(), ['borrowing' => 1])) }}"
                            class="block px-4 py-2 text-[14px] text-[#374151] hover:bg-[#F9FAFB] transition-colors">Borrowing</a>
                        <a href="{{ route('librarian.reading-log.index', array_merge(request()->query(), ['returned' => 1])) }}"
                            class="block px-4 py-2 text-[14px] text-[#374151] hover:bg-[#F9FAFB] transition-colors">Returned</a>
                        <a href="{{ route('librarian.reading-log.index', array_merge(request()->query(), ['overdue' => 1])) }}"
                            class="block px-4 py-2 text-[14px] text-[#374151] hover:bg-[#F9FAFB] transition-colors">Overdue</a>
                        <a href="{{ route('librarian.reading-log.index', array_merge(request()->query(), ['sort' => 'newest'])) }}"
                            class="block px-4 py-2 text-[14px] text-[#374151] hover:bg-[#F9FAFB] transition-colors">Newest</a>
                        <a href="{{ route('librarian.reading-log.index', array_merge(request()->query(), ['sort' => 'oldest'])) }}"
                            class="block px-4 py-2 text-[14px] text-[#374151] hover:bg-[#F9FAFB] transition-colors">Oldest</a>
                    </div>
                </div>

                <!-- ACTIVE FILTER TAGS (Muncul hanya jika filter dipilih) -->
                @if (request('borrowing') || request('returned') || request('overdue') || request('sort'))
                <div class="flex flex-wrap items-center gap-2">

                    @if (request('borrowing'))
                    <span
                        class="border border-[#D1D5DB] px-3 py-2 rounded-[6px] flex items-center gap-2 text-[16px] font-medium text-[#374151] bg-white shadow-[0_1px_2px_rgba(0,0,0,0.02)]">
                        Borrowing
                        <a
                            href="{{ route('librarian.reading-log.index', request()->except(['borrowing', 'page'])) }}">
                            <img src="{{ asset('images/icons/cancelx.png') }}"
                                class="h-3 hover:opacity-70 transition-opacity">
                        </a>
                    </span>
                    @endif

                    @if (request('returned'))
                    <span
                        class="border border-[#D1D5DB] px-3 py-2 rounded-[6px] flex items-center gap-2 text-[16px] font-medium text-[#374151] bg-white shadow-[0_1px_2px_rgba(0,0,0,0.02)]">
                        Returned
                        <a
                            href="{{ route('librarian.reading-log.index', request()->except(['returned', 'page'])) }}">
                            <img src="{{ asset('images/icons/cancelx.png') }}"
                                class="h-3 hover:opacity-70 transition-opacity">
                        </a>
                    </span>
                    @endif

                    @if (request('overdue'))
                    <span
                        class="border border-[#D1D5DB] px-3 py-2 rounded-[6px] flex items-center gap-2 text-[16px] font-medium text-[#374151] bg-white shadow-[0_1px_2px_rgba(0,0,0,0.02)]">
                        Overdue
                        <a
                            href="{{ route('librarian.reading-log.index', request()->except(['overdue', 'page'])) }}">
                            <img src="{{ asset('images/icons/cancelx.png') }}"
                                class="h-3 hover:opacity-70 transition-opacity">
                        </a>
                    </span>
                    @endif

                    @if (request('sort'))
                    <span
                        class="border border-[#D1D5DB] px-3 py-2 rounded-[6px] flex items-center gap-2 text-[16px] font-medium text-[#374151] bg-white shadow-[0_1px_2px_rgba(0,0,0,0.02)]">
                        {{ ucfirst(request('sort')) }}
                        <a
                            href="{{ route('librarian.reading-log.index', request()->except(['sort', 'page'])) }}">
                            <img src="{{ asset('images/icons/cancelx.png') }}"
                                class="h-3 hover:opacity-70 transition-opacity">
                        </a>
                    </span>
                    @endif

                    <!-- Clear Filters -->
                    <a href="{{ route('librarian.reading-log.index', request()->only('search')) }}"
                        class="text-[#575757] hover:text-black font-medium text-[16px] cursor-pointer bg-[#F3F4F6] py-2 px-3 rounded-[6px] transition-colors">
                        Clear Filters
                    </a>
                </div>
                @endif
            </div>

        </div>

        <!-- TABLE -->
        <div class="w-full overflow-x-auto">
            @if ($borrowings->count() > 0)
            <table class="w-full text-left border-collapse min-w-[900px]">
                <thead>
                    <tr class="border-b border-t border-[#E5E7EB] bg-[#F8FAFC]">
                        <th class="py-3.5 px-4 text-[16px] font-semibold text-[#6B7280]">Title</th>
                        <th class="py-3.5 px-4 text-[16px] font-semibold text-[#6B7280]">Borrowed On</th>
                        <th class="py-3.5 px-4 text-[16px] font-semibold text-[#6B7280]">Due/Returned</th>
                        <th class="py-3.5 px-4 text-[16px] font-semibold text-[#6B7280]">Status</th>
                        <th class="py-3.5 px-4 text-[16px] font-semibold text-[#6B7280] w-[100px]">Action</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach ($borrowings as $borrowing)
                    <tr
                        class="border-b border-[#F3F4F6] last:border-none hover:bg-[#F9FAFB]/50 transition-colors">

                        <!-- Title Column -->
                        <td class="py-3.5 px-4">
                            <div class="flex items-center gap-4">
                                <img src="{{ $borrowing->book->cover_image ? asset('storage/' . ltrim($borrowing->book->cover_image, '/')) : asset('images/avatar-placeholder.webp') }}"
                                    class="w-[38px] h-[52px] rounded-[3px] object-cover border border-[#E5E7EB]">
                                <span
                                    class="text-[16px] text-black font-medium">{{ $borrowing->book->title }}</span>
                            </div>
                        </td>

                        <!-- Borrowed On -->
                        <td class="py-3.5 px-4 text-[16px] text-[#4B5563]">
                            {{ $borrowing->borrow_date ? $borrowing->borrow_date->format('F j, Y') : 'N/A' }}
                        </td>

                        <!-- Due/Returned -->
                        <td class="py-3.5 px-4 text-[16px] text-[#4B5563]">
                            {{ $borrowing->return_date ? $borrowing->return_date->format('F j, Y') : 'N/A' }}
                        </td>

                        <!-- Status with Colored Dots -->
                        <td class="py-3.5 px-4">
                            @if ($borrowing->status === 'borrowed')
                            <div class="flex items-center gap-2">
                                <span class="w-2 h-2 rounded-full bg-[#3B82F6]"></span>
                                <span
                                    class="text-[#3B82F6] font-bold text-[13px] tracking-widest uppercase">BORROWED</span>
                            </div>
                            @elseif($borrowing->status === 'returned')
                            <div class="flex items-center gap-2">
                                <span class="w-2 h-2 rounded-full bg-[#22C55E]"></span>
                                <span
                                    class="text-[#22C55E] font-bold text-[13px] tracking-widest uppercase">RETURNED</span>
                            </div>
                            @elseif($borrowing->status === 'overdue')
                            <div class="flex items-center gap-2">
                                <span class="w-2 h-2 rounded-full bg-[#EF4444]"></span>
                                <span
                                    class="text-[#EF4444] font-bold text-[13px] tracking-widest uppercase">OVERDUE</span>
                            </div>
                            @else
                            <div class="flex items-center gap-2">
                                <span class="w-2 h-2 rounded-full bg-gray-500"></span>
                                <span
                                    class="text-gray-500 font-bold text-[13px] tracking-widest uppercase">{{ $borrowing->status }}</span>
                            </div>
                            @endif
                        </td>

                        <!-- Action (View Only) -->
                        <td class="py-3.5 px-4">
                            <button
                                class="w-8 h-8 rounded-[4px] bg-[#F9FAFB] border border-[#E5E7EB] flex items-center justify-center text-[#6B7280] hover:bg-white hover:border-[#3B82F6] hover:text-[#3B82F6] transition-all">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor" stroke-width="1.7" class="w-4 h-4">
                                    <path d="M2 12s4-6 10-6 10 6 10 6-4 6-10 6-10-6-10-6z" />
                                    <circle cx="12" cy="12" r="3" />
                                </svg>
                            </button>
                        </td>

                    </tr>
                    @endforeach
                </tbody>
            </table>
            @else
            <div class="py-16 text-center">
                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor"
                    viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                    </path>
                </svg>
                <p class="mt-4 text-[16px] text-gray-500">No borrowing records found for this query.</p>
            </div>
            @endif
        </div>

        <!-- PAGINATION -->
        @if ($borrowings->hasPages())
        <div class="flex justify-center items-center gap-2 mt-4 font-sans">

            <!-- Previous Button -->
            @if ($borrowings->onFirstPage())
            <button disabled
                class="border border-[#D1D5DB] px-3 py-1.5 text-[#9CA3AF] bg-[#F9FAFB] rounded-[4px] cursor-not-allowed flex items-center gap-1.5">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
                </svg>
                Previous
            </button>
            @else
            <a href="{{ $borrowings->previousPageUrl() }}"
                class="border border-[#D1D5DB] px-3 py-1.5 text-[#6C6C6C] hover:bg-[#F9FAFB] rounded-[4px] transition-colors flex items-center gap-1.5">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
                </svg>
                Previous
            </a>
            @endif

            <!-- Page Numbers -->
            @foreach ($borrowings->getUrlRange(1, $borrowings->lastPage()) as $page => $url)
            @if ($page == $borrowings->currentPage())
            <button
                class="border border-[#D1D5DB] px-3.5 py-1.5 font-medium text-[#575757] bg-white rounded-[4px]">{{ $page }}</button>
            @elseif($page <= 3 || $page>= $borrowings->lastPage() - 2 || abs($page - $borrowings->currentPage()) <= 1)
                    <a href="{{ $url }}"
                    class="text-[#6B7280] hover:text-black hover:bg-[#F9FAFB] px-3.5 py-1.5 rounded-[4px] transition-colors">{{ $page }}</a>
                    @elseif($page == 4 || $page == $borrowings->lastPage() - 3)
                    <span class="text-[#9CA3AF] px-2 tracking-widest">...</span>
                    @endif
                    @endforeach

                    <!-- Next Button -->
                    @if ($borrowings->hasMorePages())
                    <a href="{{ $borrowings->nextPageUrl() }}"
                        class="border border-[#D1D5DB] px-3 py-1.5 text-[#6C6C6C] hover:bg-[#F9FAFB] rounded-[4px] transition-colors flex items-center gap-1.5">
                        Next
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                        </svg>
                    </a>
                    @else
                    <button disabled
                        class="border border-[#D1D5DB] px-3 py-1.5 text-[#9CA3AF] bg-[#F9FAFB] rounded-[4px] cursor-not-allowed flex items-center gap-1.5">
                        Next
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                        </svg>
                    </button>
                    @endif

        </div>
        @endif

    </div>

</div>

<script>
    function readingLog() {
        return {
            // Alpine JS Scope
        };
    }
</script>

@endsection