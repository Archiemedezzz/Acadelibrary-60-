@extends('layouts.librarian')

@section('title', 'Add New Transaction - Acadelibrary')

@section('content')
    <div class="max-w-[1600px] mx-auto w-full flex flex-col gap-6">

        <div
            class="bg-white border border-[#D1D5DB] rounded-[10px] p-6 flex flex-col gap-6 lg:flex-row lg:items-center lg:justify-between">
            <div>
                <p class="text-[#6B7280] text-sm uppercase tracking-[0.2em] mb-2">Add New Transaction</p>
                <h1 class="text-[28px] font-bold text-[#111827]">Create a new borrowing record</h1>
                <p class="text-[#4B5563] mt-1">Select a scholar, choose a book, and submit the new transaction.</p>
            </div>
            <a href="{{ route('librarian.circulations') }}"
                class="inline-flex items-center gap-2 border border-[#D1D5DB] bg-[#F3F4F6] text-[#374151] px-4 py-2 rounded-[8px] hover:bg-white">
                Back to circulations
            </a>
        </div>

        <div class="grid grid-cols-1 xl:grid-cols-[1fr_340px] gap-6">
            <div class="bg-white border border-[#D1D5DB] rounded-[10px] p-6">
                <form action="{{ route('librarian.circulations.store') }}" method="POST">
                    @csrf

                    <div class="grid grid-cols-1 gap-6">
                        <div>
                            <label for="user_id" class="block text-[16px] font-medium text-[#374151] mb-2">Scholar</label>
                            <select name="user_id" id="user_id" required
                                class="w-full border border-[#D1D5DB] rounded-[6px] px-3 py-2 text-[16px] focus:outline-none focus:ring-0 focus:border-[#000000]">
                                <option value="">Select a scholar</option>
                                @foreach ($scholars as $scholar)
                                    <option value="{{ $scholar->id }}"
                                        {{ old('user_id') == $scholar->id ? 'selected' : '' }}>{{ $scholar->name }}
                                        ({{ $scholar->id_member }})</option>
                                @endforeach
                            </select>
                            @error('user_id')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="book_id" class="block text-[16px] font-medium text-[#374151] mb-2">Book</label>
                            <select name="book_id" id="book_id" required
                                class="w-full border border-[#D1D5DB] rounded-[6px] px-3 py-2 text-[16px] focus:outline-none focus:ring-0 focus:border-[#000000]">
                                <option value="">Select a book</option>
                                @foreach ($books as $book)
                                    <option value="{{ $book->id }}" {{ old('book_id') == $book->id ? 'selected' : '' }}>
                                        {{ $book->title }} by {{ $book->author }} (Stock: {{ $book->stock }})</option>
                                @endforeach
                            </select>
                            @error('book_id')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="status" class="block text-[16px] font-medium text-[#374151] mb-2">Initial
                                Status</label>
                            <select name="status" id="status" required
                                class="w-full border border-[#D1D5DB] rounded-[6px] px-3 py-2 text-[16px] focus:outline-none focus:ring-0 focus:border-[#000000]">
                                <option value="pending" {{ old('status') === 'pending' ? 'selected' : '' }}>Pending
                                </option>
                                <option value="borrowed" {{ old('status') === 'borrowed' ? 'selected' : '' }}>Borrowed
                                </option>
                            </select>
                            @error('status')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="flex justify-end gap-4 mt-6">
                        <a href="{{ route('librarian.circulations') }}"
                            class="inline-flex items-center justify-center bg-gray-500 text-white px-5 py-2 rounded-[8px] hover:bg-gray-600">Cancel</a>
                        <button type="submit"
                            class="inline-flex items-center justify-center bg-black text-white px-5 py-2 rounded-[8px] hover:bg-[#111111]">Create
                            Transaction</button>
                    </div>
                </form>
            </div>

            <div class="bg-white border border-[#D1D5DB] rounded-[10px] p-6">
                <div class="bg-[#F8FAFC] border border-[#E5E7EB] rounded-[10px] p-4 mb-5">
                    <p class="text-sm uppercase tracking-[0.2em] text-[#6B7280] mb-2">Transaction rules</p>
                    <ul class="list-disc list-inside text-[#4B5563] text-sm space-y-2">
                        <li>Choose an available book with stock greater than 0.</li>
                        <li>Pending transactions can be approved later.</li>
                        <li>Borrowed transactions will automatically set borrow and due dates.</li>
                    </ul>
                </div>
                <div class="bg-[#F8FAFC] border border-[#E5E7EB] rounded-[10px] p-4">
                    <p class="text-sm uppercase tracking-[0.2em] text-[#6B7280] mb-2">Notes</p>
                    <p class="text-[#4B5563] text-sm">Use this form to add a transaction on behalf of a scholar. If you
                        choose Borrowed, stock is updated automatically.</p>
                </div>
            </div>
        </div>
    </div>
@endsection
