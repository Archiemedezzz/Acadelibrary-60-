<?php

namespace App\Http\Controllers\Librarian;

use App\Http\Controllers\Controller;
use App\Models\Borrowing;
use Illuminate\Http\Request;

class ReadingLogController extends Controller
{
    public function index(Request $request)
    {
        $query = Borrowing::with(['book', 'user']);

        // Search by book title or user name
        if ($request->filled('search')) {
            $query->where(function ($q) {
                $q->whereHas('book', function ($subQ) {
                    $subQ->where('title', 'like', '%' . request('search') . '%');
                });
            });
        }

        // Filter by status
        $statusFilters = [];
        if ($request->has('borrowing')) {
            $statusFilters[] = 'borrowed';
        }
        if ($request->has('returned')) {
            $statusFilters[] = 'returned';
        }
        if ($request->has('overdue')) {
            $statusFilters[] = 'overdue';
        }

        if (!empty($statusFilters)) {
            $query->whereIn('status', $statusFilters);
        }

        // Sort
        if ($request->filled('sort')) {
            if ($request->sort === 'newest') {
                $query->orderBy('borrow_date', 'desc');
            } elseif ($request->sort === 'oldest') {
                $query->orderBy('borrow_date', 'asc');
            }
        } else {
            $query->latest('borrow_date');
        }

        $borrowings = $query->paginate(10);

        return view('librarian.reading-log.index', compact('borrowings'));
    }
}
