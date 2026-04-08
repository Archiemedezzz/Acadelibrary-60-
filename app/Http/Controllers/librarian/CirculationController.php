<?php

namespace App\Http\Controllers\Librarian;

use App\Http\Controllers\Controller;
use App\Models\Borrowing;
use Illuminate\Http\Request;
use Carbon\Carbon;

class CirculationController extends Controller
{
    public function index(Request $request)
    {
        $validStatuses = ['pending', 'borrowed', 'returned', 'overdue'];
        $filters = $request->query('filters', []);

        if (!is_array($filters)) {
            $filters = $filters ? [$filters] : [];
        }

        if (empty($filters) && $request->filled('status')) {
            $filters = [$request->query('status')];
        }

        $filters = array_values(array_filter($filters, fn($status) => in_array($status, $validStatuses, true)));

        $borrowings = Borrowing::with('user', 'book')
            ->when(count($filters) > 0, fn($query) => $query->whereIn('status', $filters))
            ->latest()
            ->paginate(10)
            ->withQueryString();

        $totalTransactions = Borrowing::count();
        $borrowedToday = Borrowing::whereDate('borrow_date', Carbon::today())->count();
        $returnedToday = Borrowing::whereDate('actual_return_date', Carbon::today())->count();

        return view('librarian.circulations.index', compact('borrowings', 'filters', 'totalTransactions', 'borrowedToday', 'returnedToday'));
    }

    public function show(Borrowing $borrowing)
    {
        $borrowing->load('user', 'book');
        return view('librarian.circulations.show', compact('borrowing'));
    }

    public function create()
    {
        $scholars = \App\Models\User::where('role', 'scholar')->orderBy('name')->get();
        $books = \App\Models\Book::where('stock', '>', 0)->orderBy('title')->get();

        return view('librarian.circulations.create', compact('scholars', 'books'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'book_id' => 'required|exists:books,id',
            'status' => 'required|in:pending,borrowed',
        ]);

        // Check if user already has 3 active borrowings
        $activeBorrowings = Borrowing::where('user_id', $request->user_id)
            ->whereIn('status', ['pending', 'borrowed'])
            ->count();

        if ($activeBorrowings >= 3) {
            return redirect()->back()->with('error', 'User already has 3 active borrowings. Cannot exceed the limit.');
        }

        $book = \App\Models\Book::findOrFail($request->book_id);
        if ($request->status === 'borrowed' && $book->stock <= 0) {
            return redirect()->back()->with('error', 'Selected book is out of stock.');
        }

        $borrowData = [
            'user_id' => $request->user_id,
            'book_id' => $request->book_id,
            'status' => $request->status,
        ];

        if ($request->status === 'borrowed') {
            $borrowData['borrow_date'] = now();
            $borrowData['return_date'] = now()->addDays(7);
            $book->decrement('stock');
        }

        Borrowing::create($borrowData);

        return redirect()->route('librarian.circulations')->with('success', 'Transaction created successfully.');
    }

    public function approve(Borrowing $borrowing)
    {
        if ($borrowing->status === 'pending') {
            $borrowing->update([
                'status' => 'borrowed',
                'borrow_date' => Carbon::now(),
                'return_date' => Carbon::now()->addDays(7),
            ]);

            $borrowing->book->decrement('stock');
        }

        return redirect()->back()->with('success', 'Borrowing approved.');
    }

    public function reject(Borrowing $borrowing)
    {
        if ($borrowing->status === 'pending') {
            $borrowing->update(['status' => 'canceled']);
        }

        return redirect()->back()->with('success', 'Borrowing rejected.');
    }

    public function returnBook(Borrowing $borrowing)
    {
        if ($borrowing->status === 'borrowed') {
            $borrowing->update([
                'status' => 'returned',
                'actual_return_date' => Carbon::now(),
            ]);

            // Increase stock
            $borrowing->book->increment('stock');
        }

        return redirect()->back()->with('success', 'Book returned.');
    }
}
