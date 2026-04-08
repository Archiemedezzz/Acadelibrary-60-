@extends('layouts.librarian')

@section('title', 'Discover - Acadelibrary')

@section('content')
    <div x-data="librarianDiscover()" class="max-w-[1600px] mx-auto w-full flex flex-col xl:flex-row gap-8 xl:gap-10">

        <!-- ========================================== -->
        <!-- LEFT COLUMN (Main Content) -->
        <!-- ========================================== -->
        <div class="flex-1 flex flex-col min-w-0">

            <!-- Top Banner -->
            <div
                class="w-full h-[240px] md:h-[280px] rounded-[12px] border border-black relative overflow-hidden bg-black flex flex-col justify-end p-8 shadow-sm mb-10">
                <img src="{{ asset('images/banner-abstract-bg.webp') }}"
                    class="absolute inset-0 w-full h-full object-cover opacity-80" alt="Abstract Background">

                <div class="absolute right-0 top-0 h-full w-[50%] hidden md:block">
                    <img src="{{ asset('images/bookshow.png') }}" class="w-full h-full object-cover object-left"
                        alt="Books Showcase">
                </div>

                <div class="relative z-10 w-full max-w-[500px] mb-6">
                    <div class="bg-black text-white p-5 rounded-lg shadow-xl inline-block border border-gray-800">
                        <h2 class="font-serif text-[36px] md:text-[44px] leading-tight mb-1">Discover our book</h2>
                        <p class="font-sans text-[15px] text-gray-300">
                            Explore a curated collection of knowledge, art, and history.
                        </p>
                    </div>
                </div>

                <div class="relative z-10 w-full max-w-[650px]">
                    <form method="GET" action="{{ route('librarian.discover') }}"
                        class="bg-white rounded-[6px] flex items-center px-4 py-3.5 border border-transparent focus-within:border-gray-400 focus-within:ring-4 focus-within:ring-white/20 transition-all shadow-lg">
                        @if ($selectedFilter)
                            <input type="hidden" name="filter" value="{{ $selectedFilter }}">
                        @endif
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-500 mr-3 shrink-0" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                        <input type="text" name="search" value="{{ $search }}"
                            placeholder="Search for title or author"
                            class="flex-1 bg-transparent border-none outline-none text-[15px] text-black placeholder-gray-500">
                        <button type="submit" class="ml-3 text-gray-500 hover:text-black transition-colors shrink-0">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4" />
                            </svg>
                        </button>
                    </form>
                </div>
            </div>

            <h3 class="text-[14px] font-bold text-black tracking-widest uppercase mb-4">Book Catalogue</h3>

            @php
                $filterOptions = [
                    'newest' => 'Newest',
                    'for-kid' => 'For Kid',
                    'most-borrowed' => 'Most Borrowed',
                    'fine-arts' => 'Fine Arts',
                    'digital-arts' => 'Digital Arts',
                ];
            @endphp

            <div class="flex flex-wrap items-center gap-3 mb-8">
                @foreach ($filterOptions as $filterKey => $filterLabel)
                    <a href="{{ request()->fullUrlWithQuery(['filter' => $filterKey]) }}"
                        class="flex items-center gap-2 px-3 py-1.5 border rounded-[6px] text-[13px] font-medium transition {{ $selectedFilter === $filterKey ? 'bg-black text-white border-black' : 'border-gray-300 text-gray-700 hover:bg-gray-50' }}">
                        {{ $filterLabel }}
                        @if ($selectedFilter === $filterKey)
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        @endif
                    </a>
                @endforeach

                @if ($selectedFilter || $search)
                    <a href="{{ route('librarian.discover') }}"
                        class="ml-auto flex items-center gap-2 px-3 py-1.5 border border-transparent rounded-[6px] text-[13px] font-medium text-gray-500 hover:text-black hover:bg-gray-100 transition-colors">
                        Clear Filters
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </a>
                @endif
            </div>

            <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-x-5 gap-y-10 pb-10">
                @forelse($books as $book)
                    <button type="button" @click.prevent="openBookModal(@js($book->only(['id', 'title', 'author', 'publisher', 'publication_year', 'cover_image', 'stock', 'description'])))"
                        class="group flex flex-col cursor-pointer text-left">
                        <div
                            class="relative w-full aspect-[3/4] overflow-hidden rounded-[4px] border border-gray-200 shadow-sm mb-3">
                            <img src="{{ $book->cover_image ? asset('storage/' . $book->cover_image) : asset('images/books/default.jpg') }}"
                                alt="{{ $book->title }}"
                                class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                        </div>
                        <h4
                            class="font-bold text-[14px] leading-snug text-black line-clamp-2 group-hover:text-gray-600 transition-colors">
                            {{ $book->title }}</h4>
                        <p class="text-[12px] text-gray-500 mt-1 truncate">{{ $book->author }}</p>
                    </button>
                @empty
                    <div class="col-span-full text-center py-12">
                        <p class="text-gray-500 text-[15px]">No books found</p>
                    </div>
                @endforelse
            </div>

            @if ($books->hasPages())
                <div class="pb-10">
                    {{ $books->links() }}
                </div>
            @endif
        </div>

        <!-- ========================================== -->
        <!-- RIGHT COLUMN (Widgets) -->
        <!-- ========================================== -->
        <div class="w-full xl:w-[360px] flex flex-col gap-8 shrink-0">

            <div
                class="w-full h-[120px] rounded-[12px] border border-black bg-[#DDF4F8] relative overflow-hidden flex flex-col justify-center p-6 shadow-sm">
                <div class="absolute right-[-20px] top-0 h-full w-[170px] opacity-90">
                    <img src="{{ asset('images/books-graphic-widget.webp') }}"
                        class="w-full h-full object-cover object-right" alt="Books">
                </div>
                <div class="relative z-10">
                    <h3 class="text-[11px] font-bold text-gray-600 tracking-widest uppercase mb-1">Total Borrowing</h3>
                    <div class="flex items-baseline gap-1.5">
                        <span
                            class="font-serif text-[42px] font-bold text-black leading-none">{{ $activeBorrowingCount }}</span>
                        <span class="font-sans text-[15px] font-medium text-gray-600">/ 3 books</span>
                    </div>
                </div>
            </div>

            <div class="w-full rounded-[12px] border border-black bg-white p-6 shadow-sm">
                <h3 class="text-[13px] font-bold text-black tracking-widest uppercase mb-5">Trending Archive</h3>

                <div class="flex flex-col gap-0">
                    @forelse($trendingBooks as $index => $book)
                        <div
                            class="flex items-center gap-4 {{ !$loop->last ? 'border-b border-gray-200' : '' }} py-4 {{ $loop->first ? 'first:pt-0' : '' }}">
                            <img src="{{ $book->cover_image ? asset('storage/' . $book->cover_image) : asset('images/books/default.jpg') }}"
                                alt="{{ $book->title }}"
                                class="w-[50px] aspect-[3/4] object-cover rounded-[4px] border border-gray-200 shrink-0 shadow-sm">
                            <div class="flex-1 flex flex-col justify-center min-w-0">
                                <h4 class="font-bold text-[13px] text-black leading-tight truncate">{{ $book->title }}
                                </h4>
                                <p class="text-[11px] text-gray-500 mt-1">By {{ $book->author }}
                                    {{ $book->publication_year }}</p>
                                <p class="text-[11px] text-gray-700 mt-2">Borrowed <span
                                        class="font-bold">{{ $book->borrowings_count }}</span> Times</p>
                            </div>
                            <div
                                class="w-6 h-6 bg-black text-white flex items-center justify-center rounded-[4px] font-bold text-[12px] shrink-0">
                                {{ $index + 1 }}</div>
                        </div>
                    @empty
                        <p class="text-[13px] text-gray-500 text-center py-4">No trending books yet</p>
                    @endforelse
                </div>
            </div>

            <div class="w-full rounded-[12px] border border-black bg-white p-6 shadow-sm">
                <h3 class="text-[13px] font-bold text-black tracking-widest uppercase mb-5">Recently Added</h3>

                <div class="flex flex-col gap-3">
                    @forelse($recentlyAddedBooks as $book)
                        <button type="button" @click.prevent="openBookModal(@js($book->only(['id', 'title', 'author', 'publisher', 'publication_year', 'cover_image', 'stock', 'description'])))"
                            class="border border-gray-200 rounded-[8px] p-3 flex items-center gap-4 hover:border-gray-400 transition-colors shadow-sm bg-[#FAFAFA] text-left">
                            <img src="{{ $book->cover_image ? asset('storage/' . $book->cover_image) : asset('images/books/default.jpg') }}"
                                alt="{{ $book->title }}"
                                class="w-[45px] aspect-[3/4] object-cover rounded-[4px] border border-gray-100 shrink-0 shadow-sm">
                            <div class="flex flex-col justify-center min-w-0">
                                <h4 class="font-bold text-[13px] text-black leading-snug line-clamp-2">{{ $book->title }}
                                </h4>
                                <p class="text-[11px] text-gray-500 mt-1.5 truncate">By {{ $book->author }}
                                    {{ $book->publication_year }}</p>
                            </div>
                        </button>
                    @empty
                        <p class="text-[13px] text-gray-500 text-center py-4">No books added yet</p>
                    @endforelse
                </div>
            </div>

        </div>

        <div x-show="showBookModal" x-cloak class="fixed inset-0 z-50 flex items-center justify-center px-4 py-6">
            <div @click="closeBookModal" class="absolute inset-0 bg-black/40"></div>
            <div @click.stop class="relative w-full max-w-4xl overflow-hidden rounded-[14px] bg-white shadow-2xl">
                <div class="flex items-start justify-between border-b border-gray-200 px-6 py-4">
                    <div>
                        <h2 class="text-xl font-bold text-black" x-text="selectedBook?.title"></h2>
                        <p class="text-sm text-gray-500 mt-1"
                            x-text="selectedBook ? 'By ' + selectedBook.author + ' · ' + selectedBook.publication_year : ''">
                        </p>
                    </div>
                    <button type="button" @click="closeBookModal" class="text-gray-400 hover:text-gray-700">×</button>
                </div>
                <div class="grid gap-6 lg:grid-cols-[220px_1fr] p-6">
                    <div class="rounded-[10px] overflow-hidden border border-gray-200 bg-gray-50">
                        <img :src="selectedBook && selectedBook.cover_image ? '/storage/' + selectedBook.cover_image :
                            {{ json_encode(asset('images/books/default.jpg')) }}"
                            alt="Book cover" class="h-full w-full object-cover">
                    </div>
                    <div class="space-y-5">
                        <div class="space-y-3">
                            <p class="text-[13px] font-semibold uppercase tracking-[0.22em] text-gray-500">
                                Description</p>
                            <p class="text-sm text-gray-700"
                                x-text="selectedBook?.description || 'No description available for this book.'"></p>
                        </div>
                        <div class="grid grid-cols-2 gap-3">
                            <div class="rounded-[10px] border border-gray-200 bg-[#F8FAFC] p-4">
                                <p class="text-[12px] text-gray-500">Stock</p>
                                <p class="mt-1 text-lg font-semibold text-black" x-text="selectedBook?.stock ?? 0"></p>
                            </div>
                            <div class="rounded-[10px] border border-gray-200 bg-[#F8FAFC] p-4">
                                <p class="text-[12px] text-gray-500">Author</p>
                                <p class="mt-1 text-lg font-semibold text-black"
                                    x-text="selectedBook?.author || 'Unknown'"></p>
                            </div>
                        </div>
                        <div class="flex flex-col gap-3">
                            <form method="POST" :action="borrowAction" class="flex gap-3 flex-wrap">
                                @csrf
                                <button type="submit"
                                    class="inline-flex items-center justify-center rounded-[8px] bg-black px-4 py-3 text-sm font-semibold text-white transition hover:bg-gray-900 disabled:cursor-not-allowed disabled:opacity-60"
                                    :disabled="!selectedBook || selectedBook.stock <= 0">
                                    <span
                                        x-text="selectedBook && selectedBook.stock > 0 ? 'Request Borrow' : 'Out of Stock'"></span>
                                </button>
                            </form>
                            <button type="button" @click="showFolderOptions = !showFolderOptions"
                                class="inline-flex items-center justify-center rounded-[8px] border border-gray-300 bg-white px-4 py-3 text-sm font-semibold text-gray-700 transition hover:bg-gray-50">
                                Add to Wishlist Folder
                            </button>
                        </div>
                        <div x-show="showFolderOptions" x-cloak
                            class="rounded-[10px] border border-gray-200 bg-[#F8FAFC] p-4">
                            <p class="text-sm font-semibold text-gray-700 mb-3">Select a folder</p>
                            <template x-if="folders.length">
                                <div class="grid gap-2">
                                    <template x-for="folder in folders" :key="folder.id">
                                        <button type="button" @click="addToFolder(folder.id)"
                                            class="w-full rounded-[8px] bg-white px-4 py-3 text-left text-sm text-gray-700 transition hover:bg-gray-100">
                                            <span x-text="folder.name"></span>
                                        </button>
                                    </template>
                                </div>
                            </template>
                            <template x-if="!folders.length">
                                <p class="text-sm text-gray-500">No wishlist folders yet. Create one below.</p>
                            </template>
                            <div class="mt-4 border-t border-gray-200 pt-4">
                                <button type="button" @click="showNewFolderModal = true"
                                    class="rounded-[8px] bg-black px-4 py-3 text-sm font-semibold text-white transition hover:bg-gray-900">
                                    Create New Folder
                                </button>
                            </div>
                            <form x-ref="folderForm" method="POST" :action="folderStoreAction" class="hidden">
                                @csrf
                                <input type="hidden" name="folder_id" :value="selectedFolderId">
                                <input type="hidden" name="book_id" :value="selectedBook?.id">
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div x-show="showNewFolderModal" x-cloak class="fixed inset-0 z-50 flex items-center justify-center px-4 py-6">
            <div @click="showNewFolderModal = false" class="absolute inset-0 bg-black/40"></div>
            <div @click.stop class="relative w-full max-w-md overflow-hidden rounded-[14px] bg-white shadow-2xl p-6">
                <div class="flex items-center justify-between mb-4">
                    <div>
                        <h3 class="text-lg font-bold text-black">Create Wishlist Folder</h3>
                        <p class="text-sm text-gray-500">Add a new folder to organize your wishlist.</p>
                    </div>
                    <button type="button" @click="showNewFolderModal = false"
                        class="text-gray-400 hover:text-gray-700">×</button>
                </div>
                <form method="POST" action="{{ route('librarian.folders.store') }}" class="space-y-4">
                    @csrf
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Folder Name</label>
                        <input type="text" name="name" x-model="newFolderName" placeholder="e.g. Art Books"
                            class="mt-2 w-full rounded-[10px] border border-gray-300 px-4 py-3 text-sm text-gray-700 outline-none focus:border-black"
                            required>
                    </div>
                    <div class="flex items-center justify-end gap-3">
                        <button type="button" @click="showNewFolderModal = false"
                            class="rounded-[8px] border border-gray-300 bg-white px-4 py-3 text-sm font-semibold text-gray-700 transition hover:bg-gray-50">
                            Cancel
                        </button>
                        <button type="submit"
                            class="rounded-[8px] bg-black px-4 py-3 text-sm font-semibold text-white transition hover:bg-gray-900">
                            Save Folder
                        </button>
                    </div>
                </form>
            </div>
        </div>

    </div>

    <script>
        function librarianDiscover() {
            return {
                showBookModal: false,
                showFolderOptions: false,
                showNewFolderModal: false,
                selectedBook: null,
                selectedFolderId: null,
                newFolderName: '',
                folders: @js(
    $folders->map(function ($folder) {
        return ['id' => $folder->id, 'name' => $folder->name];
    }),
),
                borrowRouteBase: '{{ url('/librarian/borrow') }}',
                folderStoreAction: '{{ route('librarian.folders.addBook') }}',
                openBookModal(book) {
                    this.selectedBook = book;
                    this.showFolderOptions = false;
                    this.showNewFolderModal = false;
                    this.selectedFolderId = null;
                    this.showBookModal = true;
                },
                closeBookModal() {
                    this.showBookModal = false;
                    this.showFolderOptions = false;
                    this.showNewFolderModal = false;
                    this.selectedBook = null;
                    this.selectedFolderId = null;
                },
                addToFolder(folderId) {
                    this.selectedFolderId = folderId;
                    this.$nextTick(() => {
                        if (this.$refs.folderForm) {
                            this.$refs.folderForm.submit();
                        }
                    });
                },
                get borrowAction() {
                    return this.selectedBook ? this.borrowRouteBase + '/' + this.selectedBook.id : '#';
                }
            };
        }
    </script>
@endsection
