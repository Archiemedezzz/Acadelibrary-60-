<?php

namespace App\Http\Controllers\Librarian;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\Borrowing;
use Illuminate\Http\Request;

class DiscoverController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->query('search');
        $selectedFilter = $request->query('filter');

        $books = Book::withCount('borrowings')
            ->when($search, fn($query) => $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                    ->orWhere('author', 'like', "%{$search}%")
                    ->orWhere('publisher', 'like', "%{$search}%");
            }))
            ->when($selectedFilter === 'for-kid', fn($query) => $query->where(function ($q) {
                $q->where('title', 'like', '%kid%')
                    ->orWhere('title', 'like', '%children%')
                    ->orWhere('description', 'like', '%kid%');
            }))
            ->when($selectedFilter === 'most-borrowed', fn($query) => $query->orderByDesc('borrowings_count'))
            ->when($selectedFilter === 'fine-arts', fn($query) => $query->where(function ($q) {
                $q->where('title', 'like', '%art%')
                    ->orWhere('description', 'like', '%art%')
                    ->orWhere('category_id', 1);
            }))
            ->when($selectedFilter === 'digital-arts', fn($query) => $query->where(function ($q) {
                $q->where('title', 'like', '%digital%')
                    ->orWhere('description', 'like', '%digital%');
            }))
            ->when($selectedFilter === 'newest', fn($query) => $query->latest('created_at'))
            ->orderByDesc('borrowings_count')
            ->paginate(20)
            ->withQueryString();

        $trendingBooks = Book::withCount('borrowings')
            ->orderByDesc('borrowings_count')
            ->take(3)
            ->get();

        $recentlyAddedBooks = Book::latest('created_at')
            ->take(3)
            ->get();

        $folders = auth()->user()->personalFolders()->with('books')->withCount('books')->get();
        $activeBorrowingCount = Borrowing::where('user_id', auth()->id())
            ->whereIn('status', ['pending', 'borrowed'])
            ->count();

        return view('librarian.discover.index', compact(
            'search',
            'selectedFilter',
            'books',
            'trendingBooks',
            'recentlyAddedBooks',
            'folders',
            'activeBorrowingCount'
        ));
    }
}
