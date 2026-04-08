@extends('layouts.librarian')

@section('title', 'Circulation Details - Acadelibrary')

@section('content')
    <div class="max-w-[1600px] mx-auto w-full flex flex-col gap-6">

        <div
            class="bg-white border border-[#D1D5DB] rounded-[10px] p-6 flex flex-col gap-6 lg:flex-row lg:items-center lg:justify-between">
            <div>
                <p class="text-[#6B7280] text-sm uppercase tracking-[0.2em] mb-2">Transaction Details</p>
                <h1 class="text-[28px] font-bold text-[#111827]">Borrowing #{{ $borrowing->id }}</h1>
                <p class="text-[#4B5563] mt-1">View borrowing status and return information for this transaction.</p>
            </div>
            <a href="{{ route('librarian.circulations') }}"
                class="inline-flex items-center gap-2 border border-[#D1D5DB] bg-[#F3F4F6] text-[#374151] px-4 py-2 rounded-[8px] hover:bg-white">
                Back to circulations
            </a>
        </div>

        <div class="grid grid-cols-1 xl:grid-cols-[380px_1fr] gap-6">
            <div class="bg-white border border-[#D1D5DB] rounded-[10px] p-6">
                <div class="flex items-center gap-4">
                    <img src="{{ $borrowing->user->avatar ? asset('storage/' . $borrowing->user->avatar) : asset('images/avatar-placeholder.webp') }}"
                        class="w-[100px] h-[100px] rounded-full object-cover border border-[#E5E7EB]">
                    <div>
                        <h2 class="text-[20px] font-semibold text-[#111827]">{{ $borrowing->user->name }}</h2>
                        <p class="text-[#6B7280]">{{ $borrowing->user->email }}</p>
                        <p class="text-[#6B7280] mt-1">{{ $borrowing->user->id_member }}</p>
                    </div>
                </div>

                <div class="mt-8 space-y-4">
                    <div class="bg-[#F8FAFC] border border-[#E5E7EB] rounded-[10px] p-5">
                        <p class="text-sm uppercase tracking-[0.2em] text-[#6B7280] mb-2">Book</p>
                        <p class="text-[#111827] font-semibold">{{ $borrowing->book->title }}</p>
                        <p class="text-[#4B5563] mt-1">{{ $borrowing->book->author }}</p>
                    </div>
                    <div class="bg-[#F8FAFC] border border-[#E5E7EB] rounded-[10px] p-5">
                        <p class="text-sm uppercase tracking-[0.2em] text-[#6B7280] mb-2">Status</p>
                        <p class="text-[#111827] font-semibold">{{ ucfirst($borrowing->status) }}</p>
                    </div>
                </div>
            </div>

            <div class="space-y-6">
                <div class="bg-white border border-[#E5E7EB] rounded-[10px] p-6">
                    <h4 class="text-[18px] font-bold text-[#1F2937] mb-4">Transaction Information</h4>
                    <div class="grid gap-4 sm:grid-cols-2">
                        <div>
                            <p class="text-sm uppercase tracking-[0.2em] text-[#6B7280] mb-2">Borrow Date</p>
                            <p class="text-[#111827]">
                                {{ $borrowing->borrow_date ? $borrowing->borrow_date->format('d M Y') : 'N/A' }}</p>
                        </div>
                        <div>
                            <p class="text-sm uppercase tracking-[0.2em] text-[#6B7280] mb-2">Due Date</p>
                            <p class="text-[#111827]">
                                {{ $borrowing->return_date ? $borrowing->return_date->format('d M Y') : 'N/A' }}</p>
                        </div>
                        <div>
                            <p class="text-sm uppercase tracking-[0.2em] text-[#6B7280] mb-2">Return Date</p>
                            <p class="text-[#111827]">
                                {{ $borrowing->actual_return_date ? $borrowing->actual_return_date->format('d M Y') : 'Not returned' }}
                            </p>
                        </div>
                        <div>
                            <p class="text-sm uppercase tracking-[0.2em] text-[#6B7280] mb-2">Book Code</p>
                            <p class="text-[#111827]">{{ $borrowing->book->book_code ?? 'N/A' }}</p>
                        </div>
                    </div>
                </div>

                <div class="bg-[#F8FAFC] border border-[#E5E7EB] rounded-[10px] p-6">
                    <p class="text-sm uppercase tracking-[0.2em] text-[#6B7280] mb-3">Notes</p>
                    <p class="text-[#4B5563] leading-relaxed">This transaction record shows the current borrowing state and
                        schedule. Use the main circulations list to approve, reject, or return the book.</p>
                </div>
            </div>
        </div>
    </div>
@endsection
