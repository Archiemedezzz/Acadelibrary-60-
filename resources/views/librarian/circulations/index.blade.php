@extends('layouts.librarian')

@section('title', 'Circulations - Acadelibrary')

@section('content')
    <div class="max-w-[1600px] mx-auto w-full flex flex-col gap-6">

        <!-- TOP STATS -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-2">

            <div class="bg-white border border-[#D1D5DB] rounded-[8px] p-6 relative">
                <h3 class="font-serif text-[16px] font-bold uppercase tracking-[0.15em] text-[#1F2937] mb-4">Total
                    Transaction</h3>
                <div class="font-sans text-[46px] font-medium text-black leading-none mb-3">{{ $totalTransactions }}</div>
                <p class="text-[16px] text-[#4B5563] font-medium">Transactions this month.</p>

                <!-- Swap Icon SVG -->
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                    stroke="currentColor" class="w-6 h-6 absolute top-6 right-6 text-black opacity-80">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M7.5 21L3 16.5m0 0L7.5 12M3 16.5h13.5m0-15L21 7.5m0 0L16.5 12M21 7.5H7.5" />
                </svg>
            </div>

            <div class="bg-white border border-[#D1D5DB] rounded-[8px] p-6 relative">
                <h3 class="font-serif text-[16px] font-bold uppercase tracking-[0.15em] text-[#1F2937] mb-4">Borrowed Today
                </h3>
                <div class="font-sans text-[46px] font-medium text-black leading-none mb-3">{{ $borrowedToday }}</div>
                <p class="text-[16px] text-[#4B5563] font-medium">Books issued today.</p>

                <!-- Swap Icon SVG -->
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                    stroke="currentColor" class="w-6 h-6 absolute top-6 right-6 text-black opacity-80">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M7.5 21L3 16.5m0 0L7.5 12M3 16.5h13.5m0-15L21 7.5m0 0L16.5 12M21 7.5H7.5" />
                </svg>
            </div>

            <div class="bg-white border border-[#D1D5DB] rounded-[8px] p-6 relative">
                <h3 class="font-serif text-[16px] font-bold uppercase tracking-[0.15em] text-[#1F2937] mb-4">Returned Today
                </h3>
                <div class="font-sans text-[46px] font-medium text-black leading-none mb-3">{{ $returnedToday }}</div>
                <p class="text-[16px] text-[#4B5563] font-medium">Books received today.</p>

                <!-- Swap Icon SVG -->
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                    stroke="currentColor" class="w-6 h-6 absolute top-6 right-6 text-black opacity-80">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M7.5 21L3 16.5m0 0L7.5 12M3 16.5h13.5m0-15L21 7.5m0 0L16.5 12M21 7.5H7.5" />
                </svg>
            </div>

        </div>

        <!-- TABLE SECTION -->
        <div class="bg-white border border-[#D1D5DB] rounded-[10px] p-6 mb-12 flex flex-col gap-6">

            <!-- SEARCH & FILTERS -->
            <div class="flex flex-col xl:flex-row xl:items-center justify-between gap-4">
                <div class="flex flex-col gap-3 w-full lg:w-auto">
                    @php
                        $activeFilters = $filters ?? [];
                        $menuFilters = array_unique($activeFilters);
                    @endphp

                    <div class="flex flex-wrap items-center gap-3">
                        <div class="relative filter-dropdown-wrapper">
                            <img src="{{ asset('images/icons/searchicon.webp') }}"
                                class="w-5 h-5 absolute left-3 top-1/2 -translate-y-1/2">

                            <input type="text" name="search" value="{{ request('search') }}"
                                placeholder="Search Transactions..."
                                class="border border-[#D1D5DB] rounded-[6px] pl-9 pr-9 py-2 text-[16px] w-[220px] md:w-[280px] focus:outline-none focus:ring-0 focus:border-[#000000] placeholder-[#9CA3AF] bg-[#F8F9FB] transition-colors">

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
                                    $availableFilters = [
                                        'pending' => 'Pending',
                                        'borrowed' => 'Borrowed',
                                        'returned' => 'Returned',
                                        'overdue' => 'Overdue',
                                    ];
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
                                        {{ ucfirst($filter) }}
                                        <a href="{{ request()->fullUrlWithQuery(['filters' => $remaining ?: null]) }}"
                                            class="inline-flex items-center justify-center">
                                            <img src="{{ asset('images/icons/cancelx.png') }}" class="h-3">
                                        </a>
                                    </span>
                                @endforeach

                                @if (count($activeFilters) > 3)
                                    <a href="{{ request()->fullUrlWithQuery(['filters' => null]) }}"
                                        class="text-[#575757] hover:text-black font-medium text-[14px] cursor-pointer bg-[#F3F4F6] py-2 px-3 rounded-[6px]">
                                        Clear Filters
                                    </a>
                                @endif
                            </div>
                        @endif
                    </div>
                </div>

                <div class="flex-shrink-0">
                    <a href="{{ route('librarian.circulations.create') }}"
                        class="bg-black text-white px-5 py-2.5 rounded-[6px] text-[16px] font-semibold hover:bg-[#111111] transition-colors whitespace-nowrap">
                        Add New Transaction
                    </a>
                </div>
            </div>

            <!-- TABLE -->
            <div class="w-full overflow-x-auto">
                <table class="w-full text-left border-collapse min-w-[900px]">
                    <thead>
                        <tr class="border-b border-[#E5E7EB]">
                            <th class="py-3 px-2 text-[18px] font-semibold text-[#6B7280]">Transaction ID</th>
                            <th class="py-3 px-2 text-[18px] font-semibold text-[#6B7280]">Scholars</th>
                            <th class="py-3 px-2 text-[18px] font-semibold text-[#6B7280]">Book Titles</th>
                            <th class="py-3 px-2 text-[18px] font-semibold text-[#6B7280]">Dates</th>
                            <th class="py-3 px-2 text-[18px] font-semibold text-[#6B7280]">Status</th>
                            <th class="py-3 px-2 text-[18px] font-semibold text-[#6B7280] w-[150px]">Action</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse ($borrowings as $borrowing)
                            <tr class="border-b border-[#F3F4F6] last:border-none hover:bg-[#F9FAFB]/50 transition-colors">

                                <!-- Transaction ID -->
                                <td class="py-3.5 px-2 text-[#4B5563] font-medium text-[16px]">
                                    {{ $borrowing->id }}
                                </td>

                                <!-- Scholar Avatar, Name & ID -->
                                <td class="py-3.5 px-2">
                                    <div class="flex items-center gap-4">
                                        <img src="{{ $borrowing->user->avatar ? asset('storage/' . $borrowing->user->avatar) : asset('images/avatar-placeholder.webp') }}"
                                            class="w-[42px] h-[42px] rounded-full object-cover border border-[#E5E7EB]">
                                        <div class="flex flex-col">
                                            <span
                                                class="text-[16px] text-black font-semibold leading-tight">{{ $borrowing->user->name }}</span>
                                            <span
                                                class="text-[14px] text-[#6B7280]">{{ $borrowing->user->id_member }}</span>
                                        </div>
                                    </div>
                                </td>

                                <!-- Book Titles -->
                                <td class="py-3.5 px-2 text-[#4B5563] text-[16px] font-medium">
                                    {{ $borrowing->book->title }}
                                </td>

                                <!-- Dates -->
                                <td class="py-3.5 px-2">
                                    <div class="flex flex-col">
                                        <span
                                            class="text-[#4B5563] text-[16px] font-medium leading-tight">{{ $borrowing->borrow_date ? $borrowing->borrow_date->format('d M Y') : 'N/A' }}</span>
                                        <span class="text-[#6B7280] text-[13px] mt-0.5">Due:
                                            {{ $borrowing->return_date ? $borrowing->return_date->format('d M Y') : 'N/A' }}</span>
                                    </div>
                                </td>

                                <!-- Status Badge -->
                                <td>
                                    @if ($borrowing->status === 'returned')
                                        <span
                                            class="bg-[#86EFAC] text-[#166534] px-3 py-1 rounded-[4px] font-bold text-[16px]">
                                            Returned
                                        </span>
                                    @elseif ($borrowing->status === 'borrowed')
                                        <span
                                            class="bg-[#FDE047] text-[#854D0E] px-3 py-1 rounded-[4px] font-bold text-[16px]">
                                            BORROWED
                                        </span>
                                    @elseif ($borrowing->status === 'pending')
                                        <span
                                            class="bg-[#D1D5DB] text-[#374151] px-3 py-1 rounded-[4px] font-bold text-[16px]">
                                            PENDING
                                        </span>
                                    @elseif ($borrowing->status === 'overdue')
                                        <span
                                            class="bg-[#FCA5A5] text-[#991B1B] px-3 py-1 rounded-[4px] font-bold text-[16px]">
                                            OVERDUE
                                        </span>
                                    @endif
                                </td>

                                <!-- Actions -->
                                <td class="py-3.5 px-2">
                                    <div class="flex items-center gap-2">
                                        @if ($borrowing->status === 'pending')
                                            <!-- APPROVE -->
                                            <form action="{{ route('librarian.circulations.approve', $borrowing) }}"
                                                method="POST" class="inline">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit"
                                                    class="w-8 h-8 rounded-[4px] bg-[#F9FAFB] border border-[#E5E7EB] flex items-center justify-center text-[#6B7280] hover:bg-white hover:border-[#10B981] hover:text-[#10B981] transition-all"
                                                    title="Approve">
                                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                        viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.7"
                                                        class="w-4 h-4">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            d="M5 13l4 4L19 7" />
                                                    </svg>
                                                </button>
                                            </form>

                                            <!-- REJECT -->
                                            <form action="{{ route('librarian.circulations.reject', $borrowing) }}"
                                                method="POST" class="inline">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit"
                                                    class="w-8 h-8 rounded-[4px] bg-[#F9FAFB] border border-[#E5E7EB] flex items-center justify-center text-[#6B7280] hover:bg-white hover:border-[#EF4444] hover:text-[#EF4444] transition-all"
                                                    title="Reject">
                                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                        viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.7"
                                                        class="w-4 h-4">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            d="M6 18L18 6M6 6l12 12" />
                                                    </svg>
                                                </button>
                                            </form>
                                        @elseif($borrowing->status === 'borrowed')
                                            <!-- RETURN -->
                                            <form action="{{ route('librarian.circulations.return', $borrowing) }}"
                                                method="POST" class="inline">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit"
                                                    class="w-8 h-8 rounded-[4px] bg-[#F9FAFB] border border-[#E5E7EB] flex items-center justify-center text-[#6B7280] hover:bg-white hover:border-[#3B82F6] hover:text-[#3B82F6] transition-all"
                                                    title="Return Book">
                                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                        viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.7"
                                                        class="w-4 h-4">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                    </svg>
                                                </button>
                                            </form>
                                        @endif

                                        <!-- VIEW -->
                                        <a href="{{ route('librarian.circulations.show', $borrowing) }}"
                                            class="w-8 h-8 rounded-[4px] bg-[#F9FAFB] border border-[#E5E7EB] flex items-center justify-center text-[#6B7280] hover:bg-white hover:border-[#3B82F6] hover:text-[#3B82F6] transition-all">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                stroke="currentColor" stroke-width="1.7" class="w-4 h-4">
                                                <path d="M2 12s4-6 10-6 10 6 10 6-4 6-10 6-10-6-10-6z" />
                                                <circle cx="12" cy="12" r="3" />
                                            </svg>
                                        </a>
                                    </div>
                                </td>

                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="py-8 text-center text-[#6B7280]">No transactions found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- PAGINATION -->
            <div class="flex justify-center items-center gap-2 mt-4 font-sans">
                {{ $borrowings->links() }}
            </div>

        </div>

    </div>
@endsection
