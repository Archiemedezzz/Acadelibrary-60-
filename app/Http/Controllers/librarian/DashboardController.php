<?php

namespace App\Http\Controllers\Librarian;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\Borrowing;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->query('search');
        $selectedFilter = $request->query('filter');

        $monthlyStart = Carbon::now()->startOfMonth();
        $monthlyEnd = Carbon::now();

        $totalBooksBorrowed = Borrowing::whereBetween('borrow_date', [$monthlyStart, $monthlyEnd])->count();
        $totalScholars = User::where('role', 'scholar')->count();
        $totalBorrowings = Borrowing::count();
        $pendingBorrowings = Borrowing::where('status', 'pending')->count();
        $borrowedBooks = Borrowing::where('status', 'borrowed')->count();
        $overdueBooks = Borrowing::where('status', 'borrowed')->where('return_date', '<', Carbon::now())->count();

        $recentBorrowings = auth()->user()->borrowings()->with('book')->latest('updated_at')->take(3)->get();
        $pendingRequests = Borrowing::with('user', 'book')->where('status', 'pending')->take(3)->get();

        $folders = auth()->user()->personalFolders()->with('books')->withCount('books')->get();
        $wishlistItems = $folders->flatMap(fn($folder) => $folder->books->pluck('id'))->unique()->count();

        $wishlistBookIds = $folders->flatMap(fn($folder) => $folder->books->pluck('id'))->unique()->values();

        $wishlistBooks = Book::withCount('borrowings')
            ->when($wishlistBookIds->isNotEmpty(), fn($query) => $query->whereIn('id', $wishlistBookIds))
            ->when($wishlistBookIds->isEmpty(), fn($query) => $query->whereRaw('1 = 0'))
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
            ->take(10)
            ->get();

        return view('librarian.home.index', compact(
            'search',
            'selectedFilter',
            'totalBooksBorrowed',
            'totalScholars',
            'totalBorrowings',
            'pendingBorrowings',
            'borrowedBooks',
            'overdueBooks',
            'recentBorrowings',
            'pendingRequests',
            'folders',
            'wishlistItems',
            'wishlistBooks'
        ));
    }
}
