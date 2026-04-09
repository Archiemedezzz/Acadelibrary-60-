@extends('layouts.scholar')

@section('title', 'Dashboard - Acadelibrary')

@section('content')
<div x-data="scholarHome()" class="max-w-[1600px] mx-auto w-full flex flex-col xl:flex-row gap-6 xl:gap-8">

    <!-- ========================================== -->
    <!-- LEFT COLUMN (Main Content) -->
    <!-- ========================================== -->
    <div class="flex-1 flex flex-col min-w-0">

        <!-- Due Books Alert Row -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-10">
            @if (count($dueBooks))
            @foreach ($dueBooks as $dueBook)
            <!-- Card -->
            <div
                class="border border-gray-300 rounded-[6px] p-3 flex flex-col justify-between bg-white shadow-sm">
                <div class="flex gap-3">
                    <img src="{{ $dueBook['book']->cover_image ? asset('storage/' . $dueBook['book']->cover_image) : asset('images/books/default.jpg') }}"
                        alt="{{ $dueBook['book']->title }}"
                        class="w-[45px] h-[64px] object-cover border border-gray-200 shrink-0">
                    <div class="flex flex-col justify-center">
                        <h4 class="font-bold text-[13px] text-black leading-snug line-clamp-2">
                            {{ $dueBook['book']->title }}
                        </h4>
                        <p class="text-[14px] text-gray-500 mt-1 truncate">By {{ $dueBook['book']->author }} ·
                            {{ $dueBook['book']->publication_year }}
                        </p>
                        <p class="text-[12px] mt-2 font-semibold" style="color: {{ $dueBook['color'] }}">
                            {{ $dueBook['text'] }}
                        </p>
                    </div>
                </div>
                <div class="w-full h-[5px] bg-gray-100 mt-3.5 rounded-full overflow-hidden">
                    <div class="h-full"
                        style="background-color: {{ $dueBook['color'] }}; width: {{ $dueBook['progress'] }}%">
                    </div>
                </div>
            </div>
            @endforeach
            @else
            <div
                class="border border-gray-300 rounded-[6px] p-6 bg-white shadow-sm col-span-1 md:col-span-3 text-center">
                <p class="font-medium text-gray-700">No current reminders. Keep exploring the library and borrow a
                    book to start tracking due dates.</p>
            </div>
            @endif
        </div>

        @if (session('success') || session('error') || $errors->any())
        <div class="mb-8">
            @if (session('success'))
            <div class="rounded-[8px] border border-green-200 bg-green-50 p-4 text-sm text-green-800">
                {{ session('success') }}
            </div>
            @endif

            @if (session('error'))
            <div class="rounded-[8px] border border-red-200 bg-red-50 p-4 text-sm text-red-800">
                {{ session('error') }}
            </div>
            @endif

            @if ($errors->any())
            <div class="rounded-[8px] border border-yellow-200 bg-yellow-50 p-4 text-sm text-yellow-900">
                <ul class="list-disc list-inside">
                    @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif
        </div>
        @endif

        <!-- WISHLIST FOLDER SECTION -->
        <div class="mb-10">
            <h3 class="font-serif text-[18px] font-bold uppercase tracking-[0.1em] text-black mb-5">Wishlist Folder</h3>
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                @foreach ($folders as $folder)
                <!-- Folder -->
                <div
                    class="aspect-square border border-gray-300 rounded-[6px] p-4 flex flex-col items-center justify-center text-center hover:border-gray-500 cursor-pointer bg-white transition-colors shadow-sm">
                    <h4 class="font-medium text-[18px] text-gray-800 leading-snug px-2">{{ $folder->name }}</h4>
                    <p class="text-[12px] text-gray-500 mt-2 font-medium">{{ $folder->books_count }} Books</p>
                </div>
                @endforeach

                <!-- New Folder -->
                <button type="button" @click="showNewFolderModal = true"
                    class="aspect-square border-2 border-dashed border-gray-300 bg-[#F0F0F0] rounded-[6px] p-4 flex flex-col items-center justify-center text-center hover:border-gray-400 cursor-pointer transition-colors shadow-sm">
                    <img src="{{ asset('images/icons/newfolder.png') }}" alt="New Folder Icon">
                    <h4 class="font-medium text-[18px] text-gray-600">New Folder</h4>
                </button>
            </div>
        </div>

        <!-- ALL WISHLIST SECTION -->
        <div>
            <!-- Header & Search -->
            <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-5">
                <h3 class="font-serif text-[15px] font-bold uppercase tracking-[0.1em] text-black">All Wishlist</h3>

                <div class="flex items-center gap-2">
                    <form method="GET" class="relative">
                        @if ($selectedFilter)
                        <input type="hidden" name="filter" value="{{ $selectedFilter }}">
                        @endif
                        <svg xmlns="http://www.w3.org/2000/svg"
                            class="h-4 w-4 absolute left-3 top-1/2 -translate-y-1/2 text-gray-400" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                        <input type="text" name="search" value="{{ $search }}" placeholder="Search"
                            class="border border-gray-300 rounded-[4px] pl-9 pr-3 py-1.5 text-[13px] w-[180px] md:w-[220px] outline-none focus:border-gray-500 placeholder-gray-400">
                    </form>
                    <button
                        class="border border-gray-300 p-[7px] rounded-[4px] hover:bg-gray-100 transition-colors text-gray-500">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-[18px] w-[18px]" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4" />
                        </svg>
                    </button>
                </div>
            </div>

            <!-- Filters -->
            @php
            $filterOptions = [
            'newest' => 'Newest',
            'for-kid' => 'For Kid',
            'most-borrowed' => 'Most Borrowed',
            'fine-arts' => 'Fine Arts',
            'digital-arts' => 'Digital Arts',
            ];
            @endphp
            <div class="flex flex-wrap items-center gap-2.5 mb-8">
                @foreach ($filterOptions as $filterKey => $filterLabel)
                <a href="{{ request()->fullUrlWithQuery(['filter' => $filterKey]) }}"
                    class="border px-3 py-1.5 rounded-[4px] text-[13px] font-medium transition {{ $selectedFilter === $filterKey ? 'bg-black text-white border-black' : 'border-gray-300 bg-white text-gray-700 hover:bg-gray-50' }}">
                    {{ $filterLabel }}
                </a>
                @endforeach

                @if ($selectedFilter || $search)
                <a href="{{ route('scholar.dashboard') }}"
                    class="ml-auto bg-[#E5E7EB] text-gray-600 font-medium px-4 py-1.5 rounded-[4px] cursor-pointer hover:bg-gray-300 transition-colors text-[13px]">
                    Clear Filters
                </a>
                @endif
            </div>

            <!-- Book Grid (2 rows, 5 columns on XL) -->
            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-x-5 gap-y-8">
                @foreach ($catalogue as $book)
                <button type="button" @click.prevent="openBookModal(@js($book->only(['id', 'title', 'author', 'publisher', 'publication_year', 'cover_image', 'stock', 'description'])))"
                    class="group flex flex-col cursor-pointer text-left">
                    <div
                        class="relative w-full aspect-[3/4] overflow-hidden rounded-[2px] shadow-[0_4px_10px_rgba(0,0,0,0.1)] mb-3 border border-gray-100">
                        <img src="{{ $book->cover_image ? asset('storage/' . $book->cover_image) : asset('images/books/default.jpg') }}"
                            alt="{{ $book->title }}"
                            class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                    </div>
                    <h4
                        class="font-bold text-[13.5px] leading-snug text-black line-clamp-2 group-hover:text-gray-600 transition-colors">
                        {{ $book->title }}
                    </h4>
                </button>
                @endforeach
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
                        <button type="button" @click="closeBookModal"
                            class="text-gray-400 hover:text-gray-700">×</button>
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
                                    x-text="selectedBook?.description || 'No description available for this book.'">
                                </p>
                            </div>
                            <div class="grid grid-cols-2 gap-3">
                                <div class="rounded-[10px] border border-gray-200 bg-[#F8FAFC] p-4">
                                    <p class="text-[12px] text-gray-500">Stock</p>
                                    <p class="mt-1 text-lg font-semibold text-black"
                                        x-text="selectedBook?.stock ?? 0"></p>
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
                                <form x-ref="folderForm" method="POST" :action="getFolderFormAction()" class="hidden">
                                    @csrf
                                    <input type="hidden" name="folder_id" :value="selectedFolderId">
                                    <input type="hidden" name="book_id" :value="selectedBook?.id">
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div x-show="showNewFolderModal" x-cloak
                class="fixed inset-0 z-50 flex items-center justify-center px-4 py-6">
                <div @click="showNewFolderModal = false" class="absolute inset-0 bg-black/40"></div>
                <div @click.stop
                    class="relative w-full max-w-md overflow-hidden rounded-[14px] bg-white shadow-2xl p-6">
                    <div class="flex items-center justify-between mb-4">
                        <div>
                            <h3 class="text-lg font-bold text-black">Create Wishlist Folder</h3>
                            <p class="text-sm text-gray-500">Add a new folder to organize your wishlist.</p>
                        </div>
                        <button type="button" @click="showNewFolderModal = false"
                            class="text-gray-400 hover:text-gray-700">×</button>
                    </div>
                    <form x-ref="newFolderForm" method="POST" :action="getFolderFormAction()" class="space-y-4">
                        @csrf
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Folder Name</label>
                            <input type="text" :name="selectedBook ? 'folder_name' : 'name'" x-model="newFolderName"
                                placeholder="e.g. Art Books"
                                class="mt-2 w-full rounded-[10px] border border-gray-300 px-4 py-3 text-sm text-gray-700 outline-none focus:border-black"
                                required>
                        </div>
                        <template x-if="selectedBook">
                            <input type="hidden" name="book_id" :value="selectedBook.id">
                        </template>
                        <div class="flex items-center justify-end gap-3">
                            <button type="button" @click="showNewFolderModal = false"
                                class="rounded-[8px] border border-gray-300 bg-white px-4 py-3 text-sm font-semibold text-gray-700 transition hover:bg-gray-50">
                                Cancel
                            </button>
                            <button type="submit"
                                class="rounded-[8px] bg-black px-4 py-3 text-sm font-semibold text-white transition hover:bg-gray-900"
                                x-text="selectedBook ? 'Create and Add This Book' : 'Create Folder'">
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Pagination -->
            <div class="flex justify-center items-center gap-2 mt-12 mb-6">
                <button
                    class="border border-gray-300 px-3 py-1.5 rounded-[4px] text-[13px] font-medium text-gray-400 flex items-center gap-1 hover:bg-gray-50 transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
                    </svg>
                    Previous
                </button>

                <button
                    class="border border-gray-300 px-3.5 py-1.5 rounded-[4px] text-[13px] font-bold text-black shadow-sm">1</button>
                <button class="px-3.5 py-1.5 text-[13px] font-medium text-gray-500 hover:text-black">2</button>
                <button class="px-3.5 py-1.5 text-[13px] font-medium text-gray-500 hover:text-black">3</button>
                <span class="px-2 text-gray-400 tracking-widest">...</span>
                <button class="px-3.5 py-1.5 text-[13px] font-medium text-gray-500 hover:text-black">15</button>

                <button
                    class="border border-gray-300 px-3 py-1.5 rounded-[4px] text-[13px] font-medium text-gray-700 flex items-center gap-1 hover:bg-gray-50 transition-colors shadow-sm">
                    Next
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                    </svg>
                </button>
            </div>

        </div>

    </div>

    <!-- ========================================== -->
    <!-- RIGHT COLUMN (Widgets) -->
    <!-- ========================================== -->
    <div class="w-full xl:w-[380px] flex flex-col gap-6 shrink-0">

        <!-- Widget: MONTHLY STATISTIC -->
        <div class="w-full rounded-[6px] border border-gray-300 bg-white p-5 shadow-[0_2px_10px_rgba(0,0,0,0.02)]">
            <h3 class="font-serif text-[18px] font-bold text-black tracking-[0.1em] uppercase mb-4">Monthly Statistic
            </h3>

            <div class="flex flex-col gap-2.5">
                <!-- Stat 1: Light Blue Box -->
                <div
                    class="w-full h-[75px] rounded-[4px] border border-gray-200 bg-[#DDF4F8] relative overflow-hidden flex flex-col justify-center px-4 shadow-sm">
                    <!-- Books Graphic bg -->
                    <div class="absolute right-[-10px] top-0 h-full w-[130px] opacity-90 mix-blend-multiply">
                        <img src="{{ asset('images/booksborrowed.png') }}"
                            class="w-full h-full object-cover object-left" alt="Books">
                    </div>
                    <div class="relative z-10">
                        <p class="text-[14px] font-medium text-gray-700 mb-1">Total Books Borrowed</p>
                        <p class="font-sans text-[28px] font-medium text-black leading-none">
                            {{ $totalBorrowedMonthly }}
                        </p>
                    </div>
                </div>

                <!-- Stat 2 -->
                <div
                    class="w-full h-[75px] rounded-[4px] border border-gray-300 bg-white flex flex-col justify-center px-4 shadow-sm">
                    <p class="text-[14px] font-medium text-gray-500 mb-1">Returned</p>
                    <p class="font-sans text-[28px] font-medium text-black leading-none">{{ $returnedMonthly }}</p>
                </div>

                <!-- Stat 3 -->
                <div
                    class="w-full h-[75px] rounded-[4px] border border-gray-300 bg-white flex flex-col justify-center px-4 shadow-sm">
                    <p class="text-[14px] font-medium text-gray-500 mb-1">On-Time Returns</p>
                    <p class="font-sans text-[28px] font-medium text-black leading-none">{{ $onTimeReturnsMonthly }}
                    </p>
                </div>

                <!-- Spacer -->
                <div class="h-2"></div>

                <!-- Stat 4 -->
                <div
                    class="w-full h-[75px] rounded-[4px] border border-gray-300 bg-white flex flex-col justify-center px-4 shadow-sm">
                    <p class="text-[14px] font-medium text-gray-500 mb-1">Items in Wishlist</p>
                    <p class="font-sans text-[28px] font-medium text-black leading-none">{{ $wishlistItems }}</p>
                </div>
            </div>
        </div>

        <!-- Widget: RECENT ACTIVITY -->
        <div class="w-full rounded-[10px] border-2 border-gray-300 bg-white p-5">
            <h3 class="font-serif text-[18px] font-bold text-black tracking-[0.1em] uppercase mb-5">Recent Activity
            </h3>

            <div class="flex flex-col">
                @foreach ($recentActivities as $activity)
                <!-- Activity -->
                <div
                    class="@if (!$loop->last) border-b border-gray-200 pb-3.5 mb-3.5 @else pb-3 mb-4 @endif">
                    <div class="flex items-center gap-2 mb-1.5">
                        <span class="w-3 h-3 rounded-full"
                            style="background-color: {{ $activity['status'] === 'returned' ? '#22C55E' : '#3B82F6' }}"></span>
                        <span class="text-[16px] font-bold tracking-widest uppercase"
                            style="color: {{ $activity['status'] === 'returned' ? '#22C55E' : '#3B82F6' }}">{{ $activity['action'] }}</span>
                    </div>
                    <p class="text-[15px] text-[#272727] font-medium leading-snug">"{{ $activity['title'] }}"
                        <span class="text-gray-500 font-normal">( {{ $activity['date'] }} )</span>.
                    </p>
                </div>
                @endforeach
                <a href="{{ route('scholar.reading-log.index') }}"
                    class="w-full bg-black text-white text-[13px] font-medium py-3 rounded-[4px] hover:bg-gray-800 transition-colors shadow-md">
                    View All
                </a>
            </div>
        </div>

    </div>

</div>

<script>
    function scholarHome() {
        return {
            showBookModal: false,
            showFolderOptions: false,
            showNewFolderModal: false,
            selectedBook: null,
            selectedFolderId: null,
            newFolderName: '',
            folders: @js(
                $folders->map(function($folder) {
                    return ['id' => $folder->id, 'name' => $folder->name];
                }),
            ),
            borrowRouteBase: '{{ url("/scholar/borrow") }}',
            folderStoreRoute: '{{ route("scholar.folders.store") }}',
            folderAddRoute: '{{ route("scholar.folders.addBook") }}',
            getFolderFormAction() {
                return this.selectedBook ? this.folderAddRoute : this.folderStoreRoute;
            },
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
                this.newFolderName = '';
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