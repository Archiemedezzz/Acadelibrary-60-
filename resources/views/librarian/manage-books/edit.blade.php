@extends('layouts.librarian')

@section('title', 'Edit Book - Acadelibrary')

@section('content')
    <div class="max-w-[1600px] mx-auto w-full flex flex-col gap-6">

        <div class="bg-white border border-[#D1D5DB] rounded-[10px] p-6">
            <div class="flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between">
                <div>
                    <p class="text-[#6B7280] text-sm uppercase tracking-[0.2em] mb-2">Edit Book</p>
                    <h1 class="text-[28px] font-bold text-[#111827]">{{ $book->title }}</h1>
                    <p class="text-[#4B5563] mt-1">Update book details and save changes.</p>
                </div>
                <a href="{{ route('librarian.manage-books') }}"
                    class="inline-flex items-center gap-2 border border-[#D1D5DB] bg-[#F3F4F6] text-[#374151] px-4 py-2 rounded-[8px] hover:bg-white">
                    Back to list
                </a>
            </div>
        </div>

        <div class="grid grid-cols-1 xl:grid-cols-[1fr_340px] gap-6">
            <div class="bg-white border border-[#D1D5DB] rounded-[10px] p-6">
                <form action="{{ route('librarian.manage-books.update', $book) }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="title" class="block text-[16px] font-medium text-[#374151] mb-2">Title</label>
                            <input type="text" name="title" id="title" value="{{ old('title', $book->title) }}"
                                required
                                class="w-full border border-[#D1D5DB] rounded-[6px] px-3 py-2 focus:outline-none focus:ring-0 focus:border-[#000000]">
                            @error('title')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="author" class="block text-[16px] font-medium text-[#374151] mb-2">Author</label>
                            <input type="text" name="author" id="author" value="{{ old('author', $book->author) }}"
                                required
                                class="w-full border border-[#D1D5DB] rounded-[6px] px-3 py-2 focus:outline-none focus:ring-0 focus:border-[#000000]">
                            @error('author')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="publisher"
                                class="block text-[16px] font-medium text-[#374151] mb-2">Publisher</label>
                            <input type="text" name="publisher" id="publisher"
                                value="{{ old('publisher', $book->publisher) }}" required
                                class="w-full border border-[#D1D5DB] rounded-[6px] px-3 py-2 focus:outline-none focus:ring-0 focus:border-[#000000]">
                            @error('publisher')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="publication_year"
                                class="block text-[16px] font-medium text-[#374151] mb-2">Publication Year</label>
                            <input type="number" name="publication_year" id="publication_year"
                                value="{{ old('publication_year', $book->publication_year) }}" required
                                class="w-full border border-[#D1D5DB] rounded-[6px] px-3 py-2 focus:outline-none focus:ring-0 focus:border-[#000000]">
                            @error('publication_year')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="isbn" class="block text-[16px] font-medium text-[#374151] mb-2">ISBN</label>
                            <input type="text" name="isbn" id="isbn" value="{{ old('isbn', $book->isbn) }}"
                                required
                                class="w-full border border-[#D1D5DB] rounded-[6px] px-3 py-2 focus:outline-none focus:ring-0 focus:border-[#000000]">
                            @error('isbn')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="stock" class="block text-[16px] font-medium text-[#374151] mb-2">Stock</label>
                            <input type="number" name="stock" id="stock" value="{{ old('stock', $book->stock) }}"
                                required min="0"
                                class="w-full border border-[#D1D5DB] rounded-[6px] px-3 py-2 focus:outline-none focus:ring-0 focus:border-[#000000]">
                            @error('stock')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="md:col-span-2">
                            <label for="cover_image" class="block text-[16px] font-medium text-[#374151] mb-2">Cover
                                Image</label>
                            <input type="file" name="cover_image" id="cover_image" accept="image/*"
                                class="w-full border border-[#D1D5DB] rounded-[6px] px-3 py-2 focus:outline-none focus:ring-0 focus:border-[#000000]">
                            @error('cover_image')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="mt-6">
                        <label for="description"
                            class="block text-[16px] font-medium text-[#374151] mb-2">Description</label>
                        <textarea name="description" id="description" rows="5"
                            class="w-full border border-[#D1D5DB] rounded-[6px] px-3 py-2 focus:outline-none focus:ring-0 focus:border-[#000000]">{{ old('description', $book->description) }}</textarea>
                        @error('description')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="flex flex-col gap-3 mt-6 sm:flex-row sm:justify-end">
                        <a href="{{ route('librarian.manage-books') }}"
                            class="inline-flex items-center justify-center bg-gray-500 text-white px-5 py-2 rounded-[8px] hover:bg-gray-600">Cancel</a>
                        <button type="submit"
                            class="inline-flex items-center justify-center bg-black text-white px-5 py-2 rounded-[8px] hover:bg-[#111111]">Update
                            Book</button>
                    </div>
                </form>
            </div>

            <div class="bg-white border border-[#D1D5DB] rounded-[10px] p-6">
                <div class="overflow-hidden rounded-[10px] border border-[#E5E7EB] mb-5">
                    <img src="{{ $book->cover_image ? asset('storage/' . $book->cover_image) : asset('images/book-cover-placeholder.png') }}"
                        alt="{{ $book->title }}" class="w-full h-[320px] object-cover">
                </div>
                <div class="space-y-4">
                    <div>
                        <p class="text-sm uppercase tracking-[0.2em] text-[#6B7280] mb-1">Book Code</p>
                        <p class="text-[16px] font-semibold text-[#111827]">{{ $book->book_code }}</p>
                    </div>
                    <div>
                        <p class="text-sm uppercase tracking-[0.2em] text-[#6B7280] mb-1">Current stock</p>
                        <p class="text-[16px] font-semibold text-[#111827]">{{ $book->stock }}</p>
                    </div>
                    <div>
                        <p class="text-sm uppercase tracking-[0.2em] text-[#6B7280] mb-1">Added on</p>
                        <p class="text-[16px] font-semibold text-[#111827]">{{ $book->created_at->format('d M Y') }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
