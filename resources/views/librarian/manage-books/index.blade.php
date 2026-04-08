@extends('layouts.librarian')

@section('title', 'Manage Books - Acadelibrary')

@section('content')
    <div class="max-w-[1600px] mx-auto w-full flex flex-col gap-6">

        <!-- TOP STATS -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-2">

            <div class="bg-white border border-[#D1D5DB] rounded-[8px] p-6 relative">
                <h3 class="font-serif text-[16px] font-bold uppercase tracking-[0.15em] text-[#1F2937] mb-4">Total Books</h3>
                <div class="font-sans text-[46px] font-medium text-black leading-none mb-3">{{ $totalBooks }}</div>
                <p class="text-[16px] text-[#4B5563] font-medium">Total registered books.</p>
                <img src="{{ asset('images/icons/bookcopy.png') }}" class="w-6 h-6 absolute top-6 right-6">
            </div>

            <div class="bg-white border border-[#D1D5DB] rounded-[8px] p-6 relative">
                <h3 class="font-serif text-[16px] font-bold uppercase tracking-[0.15em] text-[#1F2937] mb-4">Currently
                    Borrowed</h3>
                <div class="font-sans text-[46px] font-medium text-black leading-none mb-3">{{ $borrowedBooks }}</div>
                <p class="text-[16px] text-[#4B5563] font-medium">Books currently out.</p>
                <img src="{{ asset('images/icons/bookcopy.png') }}" class="w-6 h-6 absolute top-6 right-6">
            </div>

            <div class="bg-white border border-[#D1D5DB] rounded-[8px] p-6 relative">
                <h3 class="font-serif text-[16px] font-bold uppercase tracking-[0.15em] text-[#1F2937] mb-4">Out Of Stock
                </h3>
                <div class="font-sans text-[46px] font-medium text-black leading-none mb-3">{{ $outOfStock }}</div>
                <p class="text-[16px] text-[#4B5563] font-medium">Titles unavailable.</p>
                <img src="{{ asset('images/icons/bookcopy.png') }}" class="w-6 h-6 absolute top-6 right-6">
            </div>

        </div>

        <!-- TABLE -->
        <div class="bg-white border border-[#D1D5DB] rounded-[10px] p-6 mb-12 flex flex-col gap-6">

            <!-- SEARCH -->
            <div class="flex flex-col xl:flex-row xl:items-center justify-between gap-4">

                <div class="flex flex-wrap items-center gap-3">
                    @php
                        $activeFilters = $filters ?? [];
                        $menuFilters = array_unique($activeFilters);
                    @endphp
                    <form method="GET" class="relative flex items-center gap-3">
                        <div class="relative filter-dropdown-wrapper">
                            <img src="{{ asset('images/icons/searchicon.webp') }}"
                                class="w-5 h-5 absolute left-3 top-1/2 -translate-y-1/2">

                            <input type="text" name="search" value="{{ $search }}" placeholder="Search Books..."
                                class="border border-[#D1D5DB] rounded-[6px] pl-9 pr-9 py-2 text-[16px] w-[220px] md:w-[280px] focus:outline-none focus:ring-0 outline-none focus:border-[#000000] placeholder-[#9CA3AF] bg-[#F8F9FB] transition-colors">

                            @foreach ($menuFilters as $filter)
                                <input type="hidden" name="filters[]" value="{{ $filter }}">
                            @endforeach

                            <button type="button" class="filter-toggle absolute right-3 top-1/2 -translate-y-1/2"
                                aria-expanded="false" aria-label="Open filter menu">
                                <img src="{{ asset('images/icons/filter.png') }}" class="w-4 h-4">
                            </button>

                            <div
                                class="filter-menu hidden absolute right-0 top-full mt-2 w-[220px] rounded-[8px] bg-white border border-[#E5E7EB] shadow-[0_10px_30px_rgba(15,23,42,0.08)] py-2 z-20">
                                @php
                                    $availableFilters = ['available' => 'Available', 'out-of-stock' => 'Out Of Stock'];
                                    $currentFilters = $menuFilters;
                                @endphp
                                @foreach ($availableFilters as $value => $label)
                                    <a href="{{ request()->fullUrlWithQuery(['filters' => array_unique(array_merge($currentFilters, [$value]))]) }}"
                                        class="block px-4 py-2 text-[14px] text-[#374151] hover:bg-[#F9FAFB] transition-colors">
                                        {{ $label }}
                                    </a>
                                @endforeach
                            </div>
                        </div>
                    </form>

                    @if (count($activeFilters) > 0)
                        <div class="flex flex-wrap items-center gap-2">
                            @foreach ($activeFilters as $filter)
                                @php
                                    $remaining = array_values(
                                        array_filter($activeFilters, fn($item) => $item !== $filter),
                                    );
                                @endphp
                                <span
                                    class="border border-[#D1D5DB] px-3 py-2 rounded-[6px] flex items-center gap-2 text-[14px] font-medium text-[#374151] bg-white shadow-[0_1px_2px_rgba(0,0,0,0.02)]">
                                    {{ str_replace('-', ' ', ucfirst($filter)) }}
                                    <a href="{{ request()->fullUrlWithQuery(['filters' => $remaining ?: null]) }}"
                                        class="inline-flex items-center justify-center">
                                        <img src="{{ asset('images/icons/cancelx.png') }}" class="h-3">
                                    </a>
                                </span>
                            @endforeach
                            @if (count($activeFilters) > 3)
                                <a href="{{ request()->fullUrlWithQuery(['filters' => null]) }}"
                                    class="text-[#575757] hover:text-black font-medium text-[16px] cursor-pointer bg-[#F3F4F6] py-2 px-3 rounded-[6px]">Clear
                                    Filters</a>
                            @endif
                        </div>
                    @endif
                </div>

                <a href="{{ route('librarian.manage-books.create') }}"
                    class="bg-black text-white px-5 py-2.5 rounded-[5px] text-[16px] font-semibold hover:bg-[#111111] transition-colors whitespace-nowrap">
                    Add New Books
                </a>

            </div>

            <!-- TABLE -->
            <div class="w-full overflow-x-auto">
                <table class="w-full text-left border-collapse min-w-[900px]">
                    <thead>
                        <tr class="border-b border-[#E5E7EB]">
                            <th class="py-3 px-2 text-[18px] font-semibold text-[#6B7280]">Title</th>
                            <th class="py-3 px-2 text-[18px] font-semibold text-[#6B7280]">Author</th>
                            <th class="py-3 px-2 text-[18px] font-semibold text-[#6B7280]">Book Code</th>
                            <th class="py-3 px-2 text-[18px] font-semibold text-[#6B7280]">Stock</th>
                            <th class="py-3 px-2 text-[18px] font-semibold text-[#6B7280] w-[150px]">Action</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach ($books as $book)
                            <tr class="border-b border-[#F3F4F6] last:border-none hover:bg-[#F9FAFB]/50 transition-colors">

                                <td class="py-3.5 px-2">
                                    <div class="flex items-center gap-4">
                                        <img src="{{ $book->cover_image ? asset('storage/' . $book->cover_image) : asset('images/books/default.jpg') }}"
                                            class="w-[38px] h-[52px] rounded-[3px] object-cover border border-[#E5E7EB]">
                                        <div class="flex flex-col">
                                            <h4 class="font-bold text-[16px] text-[#111827]">{{ $book->title }}</h4>
                                        </div>
                                    </div>
                                </td>

                                <td class="text-[#4B5563]">{{ $book->author }}</td>
                                <td class="text-[#4B5563] uppercase">{{ $book->book_code }}</td>

                                <td>
                                    @if ($book->stock > 0)
                                        <span class="bg-[#86EFAC] text-[#166534] px-3 py-1 rounded-[4px] font-bold">
                                            {{ $book->stock }} Available
                                        </span>
                                    @else
                                        <span class="bg-[#FCA5A5] text-[#991B1B] px-3 py-1 rounded-[4px] font-bold">
                                            Out of Stock
                                        </span>
                                    @endif
                                </td>

                                <td class="py-3.5 px-2">
                                    <div class="flex items-center gap-2">

                                        <!-- VIEW (Heroicons: eye) -->
                                        <a href="{{ route('librarian.manage-books.show', $book) }}"
                                            class="w-8 h-8 rounded-[4px] bg-[#F9FAFB] border border-[#E5E7EB] flex items-center justify-center text-[#6B7280] hover:bg-white hover:border-[#3B82F6] hover:text-[#3B82F6] transition-all">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                stroke="currentColor" stroke-width="1.7" class="w-4 h-4">
                                                <path d="M2 12s4-6 10-6 10 6 10 6-4 6-10 6-10-6-10-6z" />
                                                <circle cx="12" cy="12" r="3" />
                                            </svg>
                                        </a>

                                        <!-- EDIT (Heroicons: pencil-square) -->
                                        <a href="{{ route('librarian.manage-books.edit', $book) }}"
                                            class="w-8 h-8 rounded-[4px] bg-[#F9FAFB] border border-[#E5E7EB] flex items-center justify-center text-[#6B7280] hover:bg-white hover:border-[#EAB308] hover:text-[#EAB308] transition-all">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                stroke="currentColor" stroke-width="1.7" class="w-4 h-4">
                                                <path d="M12 20h9" />
                                                <path d="M16.5 3.5a2.1 2.1 0 013 3L7 19l-4 1 1-4 12.5-12.5z" />
                                            </svg>
                                        </a>

                                        <!-- DELETE (Heroicons: trash) -->
                                        <form action="{{ route('librarian.manage-books.destroy', $book) }}" method="POST"
                                            class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                class="w-8 h-8 rounded-[4px] bg-[#F9FAFB] border border-[#E5E7EB] flex items-center justify-center text-[#6B7280] hover:bg-white hover:border-[#EF4444] hover:text-[#EF4444] transition-all"
                                                onclick="return confirm('Are you sure?')">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                    viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.7"
                                                    class="w-4 h-4">
                                                    <path d="M3 6h18" />
                                                    <path d="M8 6V4h8v2" />
                                                    <path d="M19 6l-1 14H6L5 6" />
                                                    <path d="M10 11v6M14 11v6" />
                                                </svg>
                                            </button>
                                        </form>

                                    </div>
                                </td>

                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- PAGINATION -->
            <div class="flex justify-center items-center gap-2 mt-4 font-sans">
                <button class="border border-[#D1D5DB] px-3 py-1.5 text-[#9CA3AF] hover:bg-[#F9FAFB]">
                    Previous
                </button>

                <button class="border border-[#D1D5DB] px-3 py-1.5 font-medium text-[#575757] bg-white">1</button>
                <button class="text-[#6B7280] hover:text-black hover:bg-[#F9FAFB] px-3 py-1.5">2</button>
                <button class="text-[#6B7280] hover:text-black hover:bg-[#F9FAFB] px-3 py-1.5">3</button>
                <span class="text-[#9CA3AF]">...</span>
                <button class="text-[#6B7280] hover:text-black hover:bg-[#F9FAFB] px-3 py-1.5">15</button>

                <button class="border border-[#D1D5DB] px-3 py-1.5 text-[#6C6C6C] hover:bg-[#F9FAFB]">
                    Next
                </button>
            </div>

        </div>

    </div>
@endsection
