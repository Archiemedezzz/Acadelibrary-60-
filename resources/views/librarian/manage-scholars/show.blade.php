@extends('layouts.librarian')

@section('title', 'View Scholar - Acadelibrary')

@section('content')
    <div class="max-w-[1600px] mx-auto w-full flex flex-col gap-6">

        <div class="bg-white border border-[#D1D5DB] rounded-[10px] p-6">
            <div class="flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between">
                <div>
                    <p class="text-[#6B7280] text-sm uppercase tracking-[0.2em] mb-2">Scholar Details</p>
                    <h1 class="text-[28px] font-bold text-[#111827]">{{ $scholar->name }}</h1>
                    <p class="text-[#4B5563] mt-1">Account overview and borrowing history for this scholar.</p>
                </div>
                <div class="flex flex-wrap items-center gap-3">
                    <a href="{{ route('librarian.manage-scholars') }}"
                        class="inline-flex items-center gap-2 border border-[#D1D5DB] bg-[#F3F4F6] text-[#374151] px-4 py-2 rounded-[8px] hover:bg-white">
                        Back to scholar list
                    </a>
                    <a href="{{ route('librarian.manage-scholars.edit', $scholar) }}"
                        class="inline-flex items-center gap-2 bg-yellow-500 text-white px-4 py-2 rounded-[8px] hover:bg-yellow-600">
                        Edit scholar
                    </a>
                    <form action="{{ route('librarian.manage-scholars.destroy', $scholar) }}" method="POST" class="inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                            class="inline-flex items-center gap-2 bg-red-500 text-white px-4 py-2 rounded-[8px] hover:bg-red-600"
                            onclick="return confirm('Delete this scholar?')">
                            Delete
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 xl:grid-cols-[380px_1fr] gap-6">
            <div class="bg-white border border-[#D1D5DB] rounded-[10px] p-6">
                <div class="flex flex-col items-center text-center gap-4">
                    <img src="{{ $scholar->avatar ? asset('storage/' . $scholar->avatar) : asset('images/avatar-placeholder.webp') }}"
                        class="w-[160px] h-[160px] rounded-full object-cover border border-[#E5E7EB]">
                    <div>
                        <h2 class="text-[22px] font-semibold text-[#111827]">{{ $scholar->name }}</h2>
                        <p class="text-[#6B7280]">{{ $scholar->email }}</p>
                        <p class="text-[#6B7280] font-medium mt-1">{{ $scholar->id_member }}</p>
                    </div>
                </div>

                <div class="mt-8 space-y-4">
                    <div class="bg-[#F8FAFC] border border-[#E5E7EB] rounded-[10px] p-5">
                        <p class="text-sm uppercase tracking-[0.2em] text-[#6B7280] mb-2">Status</p>
                        <p class="text-[#111827] font-semibold">{{ $scholar->is_suspended ? 'Suspended' : 'Active' }}</p>
                    </div>
                    <div class="bg-[#F8FAFC] border border-[#E5E7EB] rounded-[10px] p-5">
                        <p class="text-sm uppercase tracking-[0.2em] text-[#6B7280] mb-2">Member Since</p>
                        <p class="text-[#111827]">{{ $scholar->created_at->format('M d, Y') }}</p>
                    </div>
                </div>
            </div>

            <div class="space-y-6">
                <div class="bg-white border border-[#E5E7EB] rounded-[10px] p-6">
                    <div class="grid gap-4 md:grid-cols-2">
                        <div>
                            <p class="text-sm uppercase tracking-[0.2em] text-[#6B7280] mb-2">Phone</p>
                            <p class="text-[#111827]">{{ $scholar->phone ?? 'N/A' }}</p>
                        </div>
                        <div>
                            <p class="text-sm uppercase tracking-[0.2em] text-[#6B7280] mb-2">Address</p>
                            <p class="text-[#111827]">{{ $scholar->address ?? 'N/A' }}</p>
                        </div>
                    </div>
                </div>

                <div class="bg-white border border-[#E5E7EB] rounded-[10px] p-6">
                    <h4 class="text-[18px] font-bold text-[#1F2937] mb-4">Borrowing History</h4>
                    <div class="overflow-x-auto">
                        <table class="w-full border-collapse">
                            <thead>
                                <tr class="border-b border-[#E5E7EB]">
                                    <th
                                        class="text-left py-3 px-4 text-[14px] font-medium text-[#6B7280] uppercase tracking-wide">
                                        Book</th>
                                    <th
                                        class="text-left py-3 px-4 text-[14px] font-medium text-[#6B7280] uppercase tracking-wide">
                                        Borrow Date</th>
                                    <th
                                        class="text-left py-3 px-4 text-[14px] font-medium text-[#6B7280] uppercase tracking-wide">
                                        Due Date</th>
                                    <th
                                        class="text-left py-3 px-4 text-[14px] font-medium text-[#6B7280] uppercase tracking-wide">
                                        Return Date</th>
                                    <th
                                        class="text-left py-3 px-4 text-[14px] font-medium text-[#6B7280] uppercase tracking-wide">
                                        Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($scholar->borrowings as $borrowing)
                                    <tr class="border-b border-[#F3F4F6]">
                                        <td class="py-3 px-4 text-[#1F2937]">{{ $borrowing->book->title }}</td>
                                        <td class="py-3 px-4 text-[#1F2937]">
                                            {{ $borrowing->borrow_date->format('M d, Y') }}</td>
                                        <td class="py-3 px-4 text-[#1F2937]">{{ $borrowing->due_date->format('M d, Y') }}
                                        </td>
                                        <td class="py-3 px-4 text-[#1F2937]">
                                            {{ $borrowing->return_date ? $borrowing->return_date->format('M d, Y') : 'Not returned' }}
                                        </td>
                                        <td class="py-3 px-4">
                                            <span
                                                class="px-2 py-1 text-xs rounded-full {{ $borrowing->status === 'returned' ? 'bg-green-100 text-green-800' : ($borrowing->status === 'overdue' ? 'bg-red-100 text-red-800' : 'bg-blue-100 text-blue-800') }}">
                                                {{ ucfirst($borrowing->status) }}
                                            </span>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="py-8 text-center text-[#6B7280]">No borrowing history
                                            found.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
