<?php

namespace App\Http\Controllers\Scholar;

use App\Http\Controllers\Controller;
use App\Models\Book;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $user = auth()->user();
        $search = $request->query('search');
        $selectedFilter = $request->query('filter');

        $catalogue = Book::withCount('borrowings')
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

        $folders = $user->personalFolders()->with('books')->withCount('books')->get();
        $wishlistItems = $folders->flatMap(fn($folder) => $folder->books->pluck('id'))->unique()->count();

        $borrowings = $user->borrowings()->with('book')->latest('borrow_date')->take(4)->get();
        $recentActivities = $user->borrowings()->with('book')->latest('updated_at')->take(3)->get()->map(fn($borrowing) => [
            'title' => $borrowing->book?->title ?? 'Unknown Book',
            'action' => $borrowing->status === 'returned' ? 'RETURNED' : 'BORROWED',
            'date' => $borrowing->updated_at ? Carbon::parse($borrowing->updated_at)->diffForHumans() : 'Just now',
            'status' => $borrowing->status,
        ]);

        $monthlyStart = Carbon::now()->startOfMonth();
        $monthlyEnd = Carbon::now();

        $totalBorrowedMonthly = $user->borrowings()
            ->whereBetween('borrow_date', [$monthlyStart, $monthlyEnd])
            ->distinct('book_id')
            ->count('book_id');

        $returnedMonthly = $user->borrowings()
            ->where('status', 'returned')
            ->whereBetween('borrow_date', [$monthlyStart, $monthlyEnd])
            ->count();

        $onTimeReturnsMonthly = $user->borrowings()
            ->where('status', 'returned')
            ->whereNotNull('actual_return_date')
            ->whereColumn('actual_return_date', '<=', 'return_date')
            ->whereBetween('borrow_date', [$monthlyStart, $monthlyEnd])
            ->count();

        $dueSoonCount = $user->borrowings()
            ->where('status', 'borrowed')
            ->whereBetween('return_date', [Carbon::now(), Carbon::now()->addDays(7)])
            ->count();

        $overdueCount = $user->borrowings()
            ->where('status', 'borrowed')
            ->where('return_date', '<', Carbon::now())
            ->count();

        $trendingBooks = Book::withCount('borrowings')
            ->orderByDesc('borrowings_count')
            ->take(3)
            ->get();

        $recentBooks = Book::latest('created_at')->take(3)->get();

        $dueBooks = [];
        $borrowingsDue = $user->borrowings()->with('book')->where('status', 'borrowed')->get();
        $now = Carbon::now();

        foreach ($borrowingsDue as $borrowing) {
            $book = $borrowing->book;
            $returnDate = Carbon::parse($borrowing->return_date);
            $days = $now->diffInDays($returnDate, false);

            if ($days < 0) {
                $dueBooks[] = [
                    'book' => $book,
                    'text' => "Overdue by " . abs($days) . " days!",
                    'color' => '#DC2626',
                    'progress' => 100,
                ];
            } elseif ($days === 0) {
                $dueBooks[] = [
                    'book' => $book,
                    'text' => 'Due Today!',
                    'color' => '#EAB308',
                    'progress' => 95,
                ];
            } elseif ($days <= 2) {
                $dueBooks[] = [
                    'book' => $book,
                    'text' => "Due in {$days} days",
                    'color' => '#16A34A',
                    'progress' => 80,
                ];
            }
        }
        $dueBooks = array_slice($dueBooks, 0, 3);

        return view('scholar.home.index', compact(
            'user',
            'search',
            'selectedFilter',
            'catalogue',
            'folders',
            'wishlistItems',
            'borrowings',
            'recentActivities',
            'totalBorrowedMonthly',
            'returnedMonthly',
            'onTimeReturnsMonthly',
            'dueSoonCount',
            'overdueCount',
            'trendingBooks',
            'recentBooks',
            'dueBooks'
        ));
    }
}