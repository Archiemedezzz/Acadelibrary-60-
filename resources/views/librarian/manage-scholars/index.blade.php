@extends('layouts.librarian')

@section('title', 'Manage Scholars - Acadelibrary')

@section('content')
    <div class="max-w-[1600px] mx-auto w-full flex flex-col gap-6">

        <!-- TOP STATS -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-2">

            <div class="bg-white border border-[#D1D5DB] rounded-[8px] p-6 relative">
                <h3 class="font-serif text-[16px] font-bold uppercase tracking-[0.15em] text-[#1F2937] mb-4">Total Scholars
                </h3>
                <div class="font-sans text-[46px] font-medium text-black leading-none mb-3">{{ $totalScholars }}</div>
                <p class="text-[16px] text-[#4B5563] font-medium">Total registered members.</p>
                <img src="{{ asset('images/icons/users.png') }}" class="w-6 h-6 absolute top-6 right-6 opacity-80"
                    alt="Users">
            </div>

            <div class="bg-white border border-[#D1D5DB] rounded-[8px] p-6 relative">
                <h3 class="font-serif text-[16px] font-bold uppercase tracking-[0.15em] text-[#1F2937] mb-4">Active
                    Borrowers</h3>
                <div class="font-sans text-[46px] font-medium text-black leading-none mb-3">{{ $activeBorrowers }}</div>
                <p class="text-[16px] text-[#4B5563] font-medium">Scholars currently borrowing.</p>
                <img src="{{ asset('images/icons/users.png') }}" class="w-6 h-6 absolute top-6 right-6 opacity-80"
                    alt="Users">
            </div>

            <div class="bg-white border border-[#D1D5DB] rounded-[8px] p-6 relative">
                <h3 class="font-serif text-[16px] font-bold uppercase tracking-[0.15em] text-[#1F2937] mb-4">Suspended</h3>
                <div class="font-sans text-[46px] font-medium text-black leading-none mb-3">{{ $suspended }}</div>
                <p class="text-[16px] text-[#4B5563] font-medium">Scholars with overdue penalties.</p>
                <img src="{{ asset('images/icons/users.png') }}" class="w-6 h-6 absolute top-6 right-6 opacity-80"
                    alt="Users">
            </div>

        </div>

        <!-- TABLE -->
        <div class="bg-white border border-[#D1D5DB] rounded-[10px] p-6 mb-12 flex flex-col gap-6">

            <!-- SEARCH -->
            <div class="flex flex-col gap-4 xl:flex-row xl:items-center xl:justify-between">

                <div class="flex flex-col gap-4 w-full lg:w-auto">
                    @php
                        $activeSort = $sort;
                    @endphp

                    <div class="flex flex-col sm:flex-row sm:items-center sm:gap-3 w-full lg:w-auto">
                        <form action="{{ route('librarian.manage-scholars') }}" method="GET"
                            class="flex items-center gap-3 w-full sm:w-auto">
                            <div class="relative filter-dropdown-wrapper">
                                <img src="{{ asset('images/icons/searchicon.webp') }}"
                                    class="w-5 h-5 absolute left-3 top-1/2 -translate-y-1/2">

                                <input type="text" name="search" value="{{ $search }}"
                                    placeholder="Search Scholars..."
                                    class="w-full max-w-[360px] border border-[#D1D5DB] rounded-[6px] pl-9 pr-9 py-2 text-[16px] min-w-0 focus:outline-none focus:ring-0 focus:border-[#000000] placeholder-[#9CA3AF] bg-[#F8F9FB] transition-colors">

                                @if ($activeSort)
                                    <input type="hidden" name="sort" value="{{ $activeSort }}">
                                @endif

                                <button type="button" class="filter-toggle absolute right-3 top-1/2 -translate-y-1/2"
                                    aria-expanded="false" aria-label="Open sort menu">
                                    <img src="{{ asset('images/icons/filter.png') }}" class="w-4 h-4">
                                </button>

                                <div
                                    class="filter-menu hidden absolute right-0 top-full mt-2 w-[220px] rounded-[8px] bg-white border border-[#E5E7EB] shadow-[0_10px_30px_rgba(15,23,42,0.08)] py-2 z-20">
                                    @php
                                        $availableSorts = [
                                            'a-z' => 'A - Z',
                                            'z-a' => 'Z - A',
                                            'newest' => 'Newest',
                                            'oldest' => 'Oldest',
                                        ];
                                    @endphp
                                    @foreach ($availableSorts as $value => $label)
                                        <a href="{{ request()->fullUrlWithQuery(['sort' => $value]) }}"
                                            class="block px-4 py-2 text-[14px] text-[#374151] hover:bg-[#F9FAFB] transition-colors">
                                            {{ $label }}
                                        </a>
                                    @endforeach
                                </div>
                            </div>
                        </form>

                        @if ($activeSort)
                            <div class="flex flex-wrap items-center gap-2">
                                @php
                                    $sortLabels = [
                                        'a-z' => 'A - Z',
                                        'z-a' => 'Z - A',
                                        'newest' => 'Newest',
                                        'oldest' => 'Oldest',
                                    ];
                                @endphp
                                <span
                                    class="border border-[#D1D5DB] px-3 py-2 rounded-[6px] flex items-center gap-2 text-[14px] font-medium text-[#374151] bg-white shadow-[0_1px_2px_rgba(0,0,0,0.02)]">
                                    {{ $sortLabels[$activeSort] ?? ucfirst($activeSort) }}
                                    <a href="{{ request()->fullUrlWithQuery(['sort' => null]) }}"
                                        class="inline-flex items-center justify-center">
                                        <img src="{{ asset('images/icons/cancelx.png') }}" class="h-3">
                                    </a>
                                </span>
                            </div>
                        @endif
                    </div>
                </div>

                <div class="flex-shrink-0">
                    <a href="{{ route('librarian.manage-scholars.create') }}"
                        class="bg-black text-white px-5 py-2.5 rounded-[5px] text-[16px] font-semibold hover:bg-[#111111] transition-colors whitespace-nowrap">
                        Add New Scholar
                    </a>
                </div>
            </div>

            <!-- TABLE -->
            <div class="w-full overflow-x-auto">
                <table class="w-full text-left border-collapse min-w-[900px]">
                    <thead>
                        <tr class="border-b border-[#E5E7EB]">
                            <th class="py-3 px-2 text-[18px] font-semibold text-[#6B7280]">Scholar</th>
                            <th class="py-3 px-2 text-[18px] font-semibold text-[#6B7280]">Member-ID</th>
                            <th class="py-3 px-2 text-[18px] font-semibold text-[#6B7280]">Contact</th>
                            <th class="py-3 px-2 text-[18px] font-semibold text-[#6B7280] w-[150px]">Action</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach ($scholars as $scholar)
                            <tr class="border-b border-[#F3F4F6] last:border-none hover:bg-[#F9FAFB]/50 transition-colors">

                                <!-- Scholar Avatar, Name & Email -->
                                <td class="py-3.5 px-2">
                                    <div class="flex items-center gap-4">
                                        <img src="{{ $scholar->avatar ? asset('storage/' . $scholar->avatar) : asset('images/avatar-placeholder.webp') }}"
                                            class="w-[42px] h-[42px] rounded-full object-cover border border-[#E5E7EB]">
                                        <div class="flex flex-col">
                                            <span
                                                class="text-[16px] text-black font-semibold leading-tight">{{ $scholar->name }}</span>
                                            <span class="text-[13px] text-[#6B7280]">{{ $scholar->email }}</span>
                                        </div>
                                    </div>
                                </td>

                                <!-- Member-ID -->
                                <td class="py-3.5 px-2 text-[#4B5563] uppercase font-medium">
                                    {{ $scholar->id_member }}
                                </td>

                                <!-- Contact -->
                                <td class="py-3.5 px-2 text-[#4B5563]">
                                    {{ $scholar->phone ?? 'N/A' }}
                                </td>

                                <!-- Actions -->
                                <td class="py-3.5 px-2">
                                    <div class="flex items-center gap-2">

                                        <!-- VIEW -->
                                        <a href="{{ route('librarian.manage-scholars.show', $scholar) }}"
                                            class="w-8 h-8 rounded-[4px] bg-[#F9FAFB] border border-[#E5E7EB] flex items-center justify-center text-[#6B7280] hover:bg-white hover:border-[#3B82F6] hover:text-[#3B82F6] transition-all">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                stroke="currentColor" stroke-width="1.7" class="w-4 h-4">
                                                <path d="M2 12s4-6 10-6 10 6 10 6-4 6-10 6-10-6-10-6z" />
                                                <circle cx="12" cy="12" r="3" />
                                            </svg>
                                        </a>

                                        <!-- EDIT -->
                                        <a href="{{ route('librarian.manage-scholars.edit', $scholar) }}"
                                            class="w-8 h-8 rounded-[4px] bg-[#F9FAFB] border border-[#E5E7EB] flex items-center justify-center text-[#6B7280] hover:bg-white hover:border-[#EAB308] hover:text-[#EAB308] transition-all">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                stroke="currentColor" stroke-width="1.7" class="w-4 h-4">
                                                <path d="M12 20h9" />
                                                <path d="M16.5 3.5a2.1 2.1 0 013 3L7 19l-4 1 1-4 12.5-12.5z" />
                                            </svg>
                                        </a>

                                        <!-- DELETE -->
                                        <form action="{{ route('librarian.manage-scholars.destroy', $scholar) }}"
                                            method="POST" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                class="w-8 h-8 rounded-[4px] bg-[#F9FAFB] border border-[#E5E7EB] flex items-center justify-center text-[#6B7280] hover:bg-white hover:border-[#EF4444] hover:text-[#EF4444] transition-all"
                                                onclick="return confirm('Are you sure you want to delete this scholar?')">
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
                {{ $scholars->links() }}
            </div>

        </div>

    </div>
@endsection
