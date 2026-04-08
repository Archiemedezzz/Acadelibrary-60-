<?php

namespace App\Http\Controllers\Scholar;

use App\Http\Controllers\Controller;
use App\Models\PersonalFolder;
use Illuminate\Http\Request;

class PersonalFolderController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $user = auth()->user();

        $user->personalFolders()->create([
            'name' => $request->name,
        ]);

        return redirect()->back()->with('success', 'Wishlist folder created successfully.');
    }

    public function addBook(Request $request)
    {
        $request->validate([
            'folder_id' => 'nullable|exists:personal_folders,id',
            'book_id' => 'required|exists:books,id',
            'folder_name' => 'nullable|string|max:255',
        ]);

        $user = auth()->user();
        $folderId = $request->folder_id;
        $bookId = $request->book_id;

        // Auto-create folder if folder_name is provided but folder_id is not
        if (!$folderId && $request->folder_name) {
            $folder = $user->personalFolders()->create([
                'name' => $request->folder_name,
            ]);
            $folderId = $folder->id;
        }

        if (!$folderId) {
            return redirect()->back()->with('error', 'Please select or create a folder.');
        }

        $folder = PersonalFolder::where('id', $folderId)
            ->where('user_id', $user->id)
            ->firstOrFail();

        if ($folder->books()->where('book_id', $bookId)->exists()) {
            return redirect()->back()->with('error', 'This book is already in the selected wishlist folder.');
        }

        $folder->books()->attach($bookId);

        return redirect()->back()->with('success', 'Book added to wishlist folder.');
    }
}
