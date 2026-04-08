<?php

namespace App\Http\Controllers\Scholar;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\Borrowing;
use App\Models\PersonalFolder;
use Illuminate\Http\Request;

class DiscoverController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        // Get active borrowing count (pending + borrowed)
        $activeBorrowingCount = Borrowing::where('user_id', $user->id)
            ->whereIn('status', ['pending', 'borrowed'])
            ->count();

        // Get all books for catalogue
        $books = Book::latest('created_at')->paginate(10);

        // Get scholar wishlist folders
        $folders = PersonalFolder::where('user_id', $user->id)
            ->withCount('books')
            ->latest()
            ->get();

        // Get trending books (most borrowed)
        $trendingBooks = Book::withCount('borrowings')
            ->orderByDesc('borrowings_count')
            ->take(3)
            ->get();

        // Get recently added books
        $recentlyAddedBooks = Book::latest('created_at')
            ->take(3)
            ->get();

        return view('scholar.discover.index', compact(
            'activeBorrowingCount',
            'books',
            'folders',
            'trendingBooks',
            'recentlyAddedBooks'
        ));
    }
}
