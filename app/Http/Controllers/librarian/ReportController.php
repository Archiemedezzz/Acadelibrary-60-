<?php

namespace App\Http\Controllers\Librarian;

use App\Http\Controllers\Controller;
use App\Models\Borrowing;
use Illuminate\Http\Request;
use Carbon\Carbon;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->query('search');
        $filters = $request->query('filters', []);
        $validStatuses = ['pending', 'borrowed', 'returned', 'overdue', 'canceled'];

        if (!is_array($filters)) {
            $filters = $filters ? [$filters] : [];
        }

        $filters = array_values(array_filter($filters, fn($status) => in_array($status, $validStatuses, true)));

        $borrowings = Borrowing::with('user', 'book')
            ->when(count($filters) > 0, fn($query) => $query->whereIn('status', $filters))
            ->when($search, fn($query) => $query->where(function ($sub) use ($search) {
                $sub->where('id', 'like', "%{$search}%")
                    ->orWhereHas('user', fn($q) => $q->where('name', 'like', "%{$search}%"))
                    ->orWhereHas('book', fn($q) => $q->where('title', 'like', "%{$search}%"));
            }))
            ->latest()
            ->paginate(10)
            ->withQueryString();

        $totalCanceled = Borrowing::where('status', 'canceled')->count();
        $totalBorrowed = Borrowing::where('status', 'borrowed')->count();
        $totalOverdue = Borrowing::where('status', 'overdue')->count();

        return view('librarian.reports.index', compact(
            'borrowings',
            'filters',
            'search',
            'totalCanceled',
            'totalBorrowed',
            'totalOverdue'
        ));
    }
}
