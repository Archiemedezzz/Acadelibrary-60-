@extends('layouts.librarian')

@section('title', 'Book Details - Acadelibrary')

@section('content')
    <div class="max-w-[1600px] mx-auto w-full flex flex-col gap-6">

        <div class="bg-white border border-[#D1D5DB] rounded-[10px] p-6">
            <div class="flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between">
                <div>
                    <p class="text-[#6B7280] text-sm uppercase tracking-[0.2em] mb-2">Book Details</p>
                    <h1 class="text-[28px] font-bold text-[#111827]">{{ $book->title }}</h1>
                    <p class="text-[#4B5563] mt-1">{{ $book->author }} · {{ $book->publisher }} ·
                        {{ $book->publication_year }}</p>
                </div>

                <div class="flex flex-wrap items-center gap-3">
                    <a href="{{ route('librarian.manage-books') }}"
                        class="inline-flex items-center gap-2 border border-[#D1D5DB] bg-[#F3F4F6] text-[#374151] px-4 py-2 rounded-[8px] hover:bg-white">
                        Back to list
                    </a>
                    <a href="{{ route('librarian.manage-books.edit', $book) }}"
                        class="inline-flex items-center gap-2 bg-yellow-500 text-white px-4 py-2 rounded-[8px] hover:bg-yellow-600">
                        Edit book
                    </a>
                    <form action="{{ route('librarian.manage-books.destroy', $book) }}" method="POST" class="inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                            class="inline-flex items-center gap-2 bg-red-500 text-white px-4 py-2 rounded-[8px] hover:bg-red-600"
                            onclick="return confirm('Delete this book?')">
                            Delete
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 xl:grid-cols-[380px_1fr] gap-6">
            <div class="bg-white border border-[#D1D5DB] rounded-[10px] overflow-hidden">
                <div class="h-[460px] overflow-hidden">
                    <img src="{{ $book->cover_image ? asset('storage/' . $book->cover_image) : asset('images/book-cover-placeholder.png') }}"
                        alt="{{ $book->title }}" class="w-full h-full object-cover">
                </div>
                <div class="p-6 space-y-5">
                    <div>
                        <p class="text-sm uppercase tracking-[0.2em] text-[#6B7280] mb-1">Book Code</p>
                        <h2 class="text-[20px] font-semibold text-[#111827]">{{ $book->book_code }}</h2>
                    </div>
                    <div>
                        <p class="text-sm uppercase tracking-[0.2em] text-[#6B7280] mb-1">Publisher</p>
                        <p class="text-[#4B5563]">{{ $book->publisher }}</p>
                    </div>
                    <div>
                        <p class="text-sm uppercase tracking-[0.2em] text-[#6B7280] mb-1">Added On</p>
                        <p class="text-[#4B5563]">{{ $book->created_at->format('d M Y') }}</p>
                    </div>
                </div>
            </div>

            <div class="space-y-6">
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div class="bg-[#F8FAFC] border border-[#E5E7EB] rounded-[10px] p-5">
                        <p class="text-sm uppercase tracking-[0.2em] text-[#6B7280] mb-2">ISBN</p>
                        <p class="text-[16px] font-semibold text-[#111827]">{{ $book->isbn }}</p>
                    </div>
                    <div class="bg-[#F8FAFC] border border-[#E5E7EB] rounded-[10px] p-5">
                        <p class="text-sm uppercase tracking-[0.2em] text-[#6B7280] mb-2">Stock</p>
                        <p class="text-[16px] font-semibold text-[#111827]">{{ $book->stock }}</p>
                    </div>
                </div>

                <div class="bg-white border border-[#E5E7EB] rounded-[10px] p-6">
                    <p class="text-sm uppercase tracking-[0.2em] text-[#6B7280] mb-3">Description</p>
                    <p class="text-[#4B5563] leading-relaxed">{{ $book->description ?? 'No description available.' }}</p>
                </div>
            </div>
        </div>
    </div>
@endsection
