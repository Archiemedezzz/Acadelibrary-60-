<?php

namespace App\Http\Controllers\Librarian;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\Borrowing;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BookController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->query('search');
        $filters = $request->query('filters', []);
        $validFilters = ['available', 'out-of-stock'];

        if (!is_array($filters)) {
            $filters = $filters ? [$filters] : [];
        }

        $filters = array_values(array_filter($filters, fn($filter) => in_array($filter, $validFilters, true)));

        $books = Book::when($search, fn($query) => $query->where('title', 'like', "%{$search}%")
            ->orWhere('author', 'like', "%{$search}%")
            ->orWhere('isbn', 'like', "%{$search}%"))
            ->when(count($filters) > 0, function ($query) use ($filters) {
                $query->where(function ($query) use ($filters) {
                    if (in_array('available', $filters, true)) {
                        $query->orWhere('stock', '>', 0);
                    }
                    if (in_array('out-of-stock', $filters, true)) {
                        $query->orWhere('stock', '<=', 0);
                    }
                });
            })
            ->paginate(10)
            ->withQueryString();

        $totalBooks = Book::count();
        $borrowedBooks = Borrowing::where('status', 'borrowed')->distinct('book_id')->count();
        $outOfStock = Book::where('stock', 0)->count();

        return view('librarian.manage-books.index', compact('books', 'search', 'filters', 'totalBooks', 'borrowedBooks', 'outOfStock'));
    }

    public function create()
    {
        return view('librarian.manage-books.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'author' => 'required|string|max:255',
            'publisher' => 'required|string|max:255',
            'publication_year' => 'required|integer|min:1000|max:' . (date('Y') + 1),
            'isbn' => 'required|string|unique:books',
            'description' => 'nullable|string',
            'stock' => 'required|integer|min:0',
            'cover_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $data = $request->all();

        if ($request->hasFile('cover_image')) {
            $data['cover_image'] = $request->file('cover_image')->store('books', 'public');
        }

        Book::create($data);

        return redirect()->route('librarian.manage-books')->with('success', 'Book added successfully.');
    }

    public function show(Book $book)
    {
        return view('librarian.manage-books.show', compact('book'));
    }

    public function edit(Book $book)
    {
        return view('librarian.manage-books.edit', compact('book'));
    }

    public function update(Request $request, Book $book)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'author' => 'required|string|max:255',
            'publisher' => 'required|string|max:255',
            'publication_year' => 'required|integer|min:1000|max:' . (date('Y') + 1),
            'isbn' => 'required|string|unique:books,isbn,' . $book->id,
            'description' => 'nullable|string',
            'stock' => 'required|integer|min:0',
            'cover_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $data = $request->all();

        if ($request->hasFile('cover_image')) {
            if ($book->cover_image) {
                Storage::disk('public')->delete($book->cover_image);
            }
            $data['cover_image'] = $request->file('cover_image')->store('books', 'public');
        }

        $book->update($data);

        return redirect()->route('librarian.manage-books')->with('success', 'Book updated successfully.');
    }

    public function destroy(Book $book)
    {
        if ($book->cover_image) {
            Storage::disk('public')->delete($book->cover_image);
        }
        $book->delete();

        return redirect()->route('librarian.manage-books')->with('success', 'Book deleted successfully.');
    }
}
