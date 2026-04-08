<?php

namespace App\Http\Controllers\Scholar;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\Borrowing;
use Illuminate\Http\Request;

class BorrowController extends Controller
{
    public function borrow(Book $book)
    {
        $user = auth()->user();

        // Check if already borrowed or requested
        $existing = Borrowing::where('user_id', $user->id)
            ->where('book_id', $book->id)
            ->whereIn('status', ['pending', 'borrowed'])
            ->first();

        if ($existing) {
            return redirect()->back()->with('error', 'You have already requested or borrowed this book.');
        }

        // Check if user already has 3 active borrowings
        $activeBorrowings = Borrowing::where('user_id', $user->id)
            ->whereIn('status', ['pending', 'borrowed'])
            ->count();

        if ($activeBorrowings >= 3) {
            return redirect()->back()->with('error', 'You can only borrow maximum 3 books at a time. Please return some books first.');
        }

        if ($book->stock <= 0) {
            return redirect()->back()->with('error', 'Book is out of stock.');
        }

        Borrowing::create([
            'user_id' => $user->id,
            'book_id' => $book->id,
            'status' => 'pending',
        ]);

        return redirect()->back()->with('success', 'Borrow request submitted.');
    }
}